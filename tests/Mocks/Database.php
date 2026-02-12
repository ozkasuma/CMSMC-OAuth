<?php
/**
 * Mock Database for testing
 */

class MockDatabase
{
    private array $queries = [];
    private array $results = [];
    private int $resultIndex = 0;
    
    public function Execute(string $sql, array $params = []): bool
    {
        $this->queries[] = ['sql' => $sql, 'params' => $params, 'type' => 'execute'];
        return true;
    }
    
    public function GetOne(string $sql, array $params = [])
    {
        $this->queries[] = ['sql' => $sql, 'params' => $params, 'type' => 'getone'];
        return $this->getNextResult();
    }
    
    public function GetRow(string $sql, array $params = []): ?array
    {
        $this->queries[] = ['sql' => $sql, 'params' => $params, 'type' => 'getrow'];
        return $this->getNextResult();
    }
    
    public function GetArray(string $sql, array $params = []): array
    {
        $this->queries[] = ['sql' => $sql, 'params' => $params, 'type' => 'getarray'];
        return $this->getNextResult() ?? [];
    }
    
    public function GetAll(string $sql, array $params = []): array
    {
        return $this->GetArray($sql, $params);
    }
    
    public function GetCol(string $sql, array $params = []): array
    {
        $this->queries[] = ['sql' => $sql, 'params' => $params, 'type' => 'getcol'];
        return $this->getNextResult() ?? [];
    }
    
    public function Insert_ID(): int
    {
        return 1;
    }
    
    public function Affected_Rows(): int
    {
        return 1;
    }
    
    public function qStr(string $str): string
    {
        return "'" . addslashes($str) . "'";
    }
    
    // Test helpers
    
    public function addResult($result): void
    {
        $this->results[] = $result;
    }
    
    public function setResults(array $results): void
    {
        $this->results = $results;
        $this->resultIndex = 0;
    }
    
    private function getNextResult()
    {
        if ($this->resultIndex < count($this->results)) {
            return $this->results[$this->resultIndex++];
        }
        return null;
    }
    
    public function getQueries(): array
    {
        return $this->queries;
    }
    
    public function getLastQuery(): ?array
    {
        return end($this->queries) ?: null;
    }
    
    public function clearQueries(): void
    {
        $this->queries = [];
    }
    
    public function reset(): void
    {
        $this->queries = [];
        $this->results = [];
        $this->resultIndex = 0;
    }
}
