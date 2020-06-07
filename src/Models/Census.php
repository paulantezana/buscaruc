<?php
class Census
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function insert($census)
    {
        try {
            $stmt = $this->db->prepare('CALL insert_row_census(:ruc, :social_reason, :address, :state, :domicile_condition, :ubigeo)');
            $stmt->bindParam(':ruc', $census['ruc'], PDO::PARAM_INT);
            $stmt->bindParam(':social_reason', $census['social_reason'], PDO::PARAM_STR_CHAR);
            $stmt->bindParam(':address', $census['address'], PDO::PARAM_STR_CHAR);
            $stmt->bindParam(':state', $census['state'], PDO::PARAM_STR_CHAR);
            $stmt->bindParam(':domicile_condition', $census['domicile_condition'], PDO::PARAM_STR_CHAR);
            $stmt->bindParam(':ubigeo', $census['ubigeo'], PDO::PARAM_STR_CHAR);

            if (!$stmt->execute()) {
                throw new Exception($stmt->errorInfo()[2]);
            }
        } catch (Exception $e) {
            throw new Exception('Line: ' . $e->getLine() . ' ' . $e->getMessage());
        }
    }

    public function queryByRuc($ruc)
    {
        try {
            $stmt = $this->db->prepare('SELECT 
                                                ruc, 
                                                social_reason,
                                                address,
                                                state,
                                                domicile_condition,
                                                ubigeo
                                        FROM census
                                        WHERE ruc = :ruc');
            $stmt->bindParam(':ruc', $ruc);

            if (!$stmt->execute()) {
                throw new Exception($stmt->errorInfo()[2]);
            }
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception('Line: ' . $e->getLine() . ' ' . $e->getMessage());
        }
    }
}
