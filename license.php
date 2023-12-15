<?php

$csvFileName = 'license.csv';
$jsonFilePath = './composer.lock';

class Composer implements ArrayAccess
{
    private array $container;

    function __construct(string $path)
    {
        if (!file_exists($path)) {
            die("ファイルが存在しません: {$path}");
        }
        $jsonString = file_get_contents($path);
        $this->container = json_decode($jsonString, true);
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}

class LicenseCsv
{
    private string $path;
    private array $data = [];

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function addPackage(array $package): void
    {
        array_push($this->data, [
            "{$package["name"]}@{$package["version"]}",
            implode(",", $package["license"]),
            $package["source"]["url"],
        ]);
    }

    public function export(): void
    {
        $file = fopen($this->path, 'w');
        if ($file === false) {
            die("ファイルを開けませんでした: " . $this->path);
        }

        foreach ($this->data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
}

$composer = new Composer($jsonFilePath);
$licenseCsv = new LicenseCsv($csvFileName);

foreach ($composer["packages"] as $package) {
    $licenseCsv->addPackage($package);
}

$licenseCsv->export();
