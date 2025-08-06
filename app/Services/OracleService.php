<?php

// app/Services/OracleService.php
namespace App\Services;

class OracleService
{
    public function getUserDetails($erpId)
{
    try {
        // 1. Verify connection
        $connection = \DB::connection('oracle');
        \Log::info("Oracle connection established: " . get_class($connection));
        
        // 2. Verify the exact query being sent
        $query = "SELECT MIM_PSOPRDEFN.OPRID, MIM_PSOPRDEFN.EMPLID 
                 FROM SYSADM.MIM_PSOPRDEFN 
                 WHERE OPRID = :erp_id";
        \Log::info("Preparing query: " . $query);
        \Log::info("With parameter: " . $erpId);

        // 3. Execute with logging
        $results = $connection->select($query, ['erp_id' => $erpId]);
        
        \Log::info("Query results: " . json_encode($results));
        
        if (empty($results)) {
            \Log::warning("No results found for OPRID: " . $erpId);
        }

        return $results[0] ?? null;

    } catch (\Exception $e) {
        \Log::error("Oracle query failed: " . $e->getMessage());
        \Log::error("Trace: " . $e->getTraceAsString());
        return null;
    }
}
}