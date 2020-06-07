<?php

require_once(MODEL_PATH . '/User.php');
require_once(MODEL_PATH . '/Census.php');
require_once(MODEL_PATH . '/CensusFile.php');
require_once(CERVICE_PATH . '/Census/CensusScraping.php');

class CensusController extends Controller
{
    private $connection;
    private $userModel;
    private $censusModel;
    private $censusFileModel;
    private $censusscraping;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->userModel = new User($connection);
        $this->censusscraping = new CensusScraping();
        $this->censusModel = new Census($connection);
        $this->censusFileModel = new CensusFile($connection);
    }

    public function dowloand()
    {
        $res = new Result();
        try {
            $resCen = $this->censusscraping->dowloand();
            if (!$resCen->success) {
                throw new Exception($resCen->message);
            }

            $res->message = $resCen->message;
            $res->success = true;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function unZip()
    {
        $res = new Result();
        try {
            $resCen = $this->censusscraping->unZip();
            if (!$resCen->success) {
                throw new Exception($resCen->message);
            }

            $res->message = $resCen->message;
            $res->success = true;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function prepare()
    {
        $res = new Result();
        $this->connection->beginTransaction();
        try {
            $resCen = $this->censusscraping->splitFile();
            if (!$resCen->success) {
                throw new Exception($resCen->message);
            }

            $filePaths = $resCen->result;

            $this->censusFileModel->truncate();
            foreach ($filePaths as $fileRow) {
                $this->censusFileModel->insert(['filePath' => $fileRow]);
            }

            $this->connection->commit();
            $res->message = $resCen->message;
            $res->success = true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function getFiles()
    {
        $res = new Result();
        try {
            $censusFile = $this->censusFileModel->getAll();

            $partial = $this->render('partials/filesPartial.php', [
                'censusFile' => $censusFile,
            ], '', true);

            $res->html = $partial;
            $res->success = true;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function getFilesIsNotProcess()
    {
        $res = new Result();
        try {
            $censusFile = $this->censusFileModel->getAllIsNotProcess();

            $res->result = $censusFile;
            $res->success = true;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function setData()
    {
        $res = new Result();
        $this->connection->beginTransaction();
        try {
            $postData = file_get_contents('php://input');
            $body = json_decode($postData, true);
            $startTime = microtime(true);

            $filePath = $body['censusFileId'];

            $censusFile = $this->censusFileModel->getById($body['censusFileId']);

            $filePath = $censusFile['file_path'];
            if (!is_file($filePath)) {
                throw new Exception('File not found');
            }

            ini_set('max_execution_time', 2000);

            $filePath = fopen($filePath, 'r');
            while (!feof($filePath)) {
                $linea = fgets($filePath);
                $dataRow = explode('|', utf8_encode($linea));
                if(count($dataRow) <= 1){
                    continue;
                }

                $entity = [];
                $entity['ruc'] = $dataRow[0];
                $entity['social_reason'] = $dataRow[1];
                $entity['address'] = '';
                $entity['domicile_condition'] = $dataRow[3];
                $entity['state'] = $dataRow[2];
                $entity['ubigeo'] = '';

                $entity['address'] .= $dataRow[5] != '-' ? $dataRow[5] : '';
                $entity['address'] .= $dataRow[6] != '-' ? $dataRow[6] : '';
                $entity['address'] .= $dataRow[9] != '-' ? 'NRO. ' . $dataRow[9] : '';
                $entity['address'] .= $dataRow[10] != '-' ? 'INT. ' . $dataRow[10] : '';
                $entity['address'] .= $dataRow[11] != '-' ? 'LT. ' . $dataRow[11] : '';
                $entity['address'] .= $dataRow[13] != '-' ? 'MZ. ' . $dataRow[13] : '';
                $entity['address'] .= $dataRow[7] != '-' ? $dataRow[7] : '';
                $entity['address'] .= $dataRow[8] != '-' ? $dataRow[8] : '';
                $entity['address'] .= $dataRow[12] != '-' ? 'DPTO. ' . $dataRow[12] : '';
                $entity['address'] .= $dataRow[14] != '-' ? 'KM. ' . $dataRow[14] : '';

                $this->censusModel->insert($entity);
            }
            fclose($filePath);

            $this->censusFileModel->updateById($body['censusFileId'], [
                'is_process' => true,
            ]);
            $endTime = microtime(true);

            $this->connection->commit();
            $res->message = 'El proceso terminó exitosamente en ' . ($endTime - $startTime) . ' seconds';
            $res->success = true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }
}