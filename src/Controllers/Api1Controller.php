<?php

require_once(MODEL_PATH . '/Census.php');

class Api1Controller extends Controller
{
    private $connection;
    private $censusModel;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->censusModel = new Census($connection);
    }

    public function query()
    {
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");

        $res = new Result();
        try {
            if (!isset($_GET['ruc'])) {
                throw new Exception('Ingrese un ruc');
            }
            $ruc = $_GET['ruc'];

            if (!rucIsValid($ruc)) {
                throw new Exception('Formato de ruc invalido');
            }

            $census = $this->censusModel->queryByRuc($ruc);
            if ($census == false) {
                throw new Exception('No se encontró ningún resultado');
            }

            $res->result = $census;
            $res->message = 'Success';
            $res->success = true;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function oldApi()
    {
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");

        $res = new Result();
        $res->errorMessage = '';
        $res->socialReason = '';
        $res->fiscalAddress = '';
        try {
            if (!isset($_GET['ruc'])) {
                throw new Exception('Ingrese un ruc');
            }
            $ruc = $_GET['ruc'];

            if (!rucIsValid($ruc)) {
                throw new Exception('Formato de ruc invalido');
            }

            $census = $this->censusModel->queryByRuc($ruc);
            if ($census == false) {
                throw new Exception('No se encontró ningún resultado');
            }

            $res->ruc =  $census['ruc'];
            $res->socialReason =  $census['social_reason'];
            $res->fiscalAddress =  $census['address'];
            $res->message = 'Success';
            $res->success = true;
        } catch (Exception $e) {
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function oldApiDni()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');

        $res = new Result();
        $res->message = '';
        try {
            if (!isset($_GET['dni'])) {
                throw new Exception('Ingrese un dni');
            }
            $dni = $_GET['dni'];
            $type = isset($_GET['type']) ? $_GET['type'] : 1;

            if (strlen($dni) != 8) {
                throw new Exception('EL DNI debe contener 8 dígitos');
            }

            $curl = curl_init();
            $options = [
                CURLOPT_URL => 'https://aplicaciones007.jne.gob.pe/srop_publico/Consulta/api/AfiliadoApi/GetNombresCiudadano',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'CODDNI=' . $dni,
                CURLOPT_HTTPHEADER => array(
                    'cache-control: no-cache',
                    'content-type: application/x-www-form-urlencoded',
                    'requestverificationtoken: Dmfiv1Unnsv8I9EoXEzbyQExSD8Q1UY7viyyf_347vRCfO-1xGFvDddaxDAlvm0cZ8XgAKTaWclVFnnsGgoy4aLlBGB5m-E8rGw_ymEcCig1:eq4At-H2zqgXPrPnoiDGFZH0Fdx5a-1UiyVaR4nQlCvYZzAhzmvWxLwkUk6-yORYrBBxEnoG5sm-Hkiyc91so6-nHHxIeLee5p700KE47Cw1'
                ),
            ];

            curl_setopt_array($curl, $options);
            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                throw new Exception(curl_error($curl));
            }

            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($statusCode != 200) {
                throw new Exception('Curl status Code: ' . $statusCode);
            }

            if ($response == null || $response == '') {
                throw new Exception('No se encontraron datos suficientes');
            }

            $dataRes = json_decode($response, true);
            $data = explode('|', $dataRes['data']);
            if (strlen($data[1]) == 0 || strlen($data[2]) == 0) {
                throw new Exception('No se encontró ningun dato con el DNI: ' . $dni);
            }

            $res->success = true;
            switch ($type) {
                case 2:
                    $res->result = [
                        'name' => $data[2],
                        'lastName' => $data[0] . ' ' . $data[1],
                        'documentNumber' => $dni,
                    ];
                    break;
                case 3:
                    $res->result = [
                        'name' => $data[2],
                        'mothersLastName' => $data[1],
                        'lastName' => $data[0],
                        'documentNumber' => $dni,
                    ];
                    break;
                default:
                    $res->result = [
                        'socialReason' => $data[0] . ' ' . $data[1] . ' ' .  $data[2],
                        'documentNumber' => $dni,
                    ];
                    break;
            }
        } catch (Exception $e) {
            $res->message = $e->getMessage();
        }

        echo json_encode($res);
    }
}
