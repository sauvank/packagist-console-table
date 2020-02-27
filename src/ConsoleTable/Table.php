<?php

namespace ConsoleTable;

class Table
{
    private $headerColumn = [];
    private $lines;
    private $separatorLine = "";
    private $separatorBorder = "";
    private $mlr = 1; // number character margin into column.
    private $showNumberRow = true; // shwo number row.
    private $tableInString = "";
    private $rowInString = [];
    private $columnTitleString = [];
    private $defaultSizeCol = false;

    public function __construct(array $headerColumn, array $lines, array $conf = [])
    {
        //Conf
        $this->setConf($conf);
        $this->lines = $lines;
        $headerColumn = $this->parseDataTitleColumns($headerColumn);
        if($this->showNumberRow){
            array_unshift($headerColumn, ['name' => 'Row', 'size' => 4]);
        }

        $this->headerColumn = $headerColumn;
//        $this->separatorLine = self::charGenerator(self::getLengthColumn($headerColumn), "-") . "\n";;
        $this->separatorBorder =  $this->separator(true);
        $this->separatorLine = $this->separator(false);
        self::setColumnTitle($headerColumn);
        self::setLines($lines);
    }

    /**
     * Show all row of table.
     */
    public function show(): void {
        echo $this->tableInString;
    }

    /**
     * Show one specific row.
     * @param int $row
     */
    public function showRow(int $row) :void {
        echo $this->columnTitleString;
        echo $this->rowInString[$row - 1];
    }

    /**
     * Create column with title.
     * @param array $headerColumn
     */
    private function setColumnTitle(array $headerColumn): void{
        $this->tableInString .= $this->separatorBorder;
        $columnString = "";
        foreach ($headerColumn as $key => $value){
            $columnString .= $this->addToColumn($value['name'], $key);
        }
        $columnString .= "|\n$this->separatorLine";
        $this->tableInString .= $columnString;
        $this->columnTitleString = $this->separatorLine.$columnString;
    }

    private function setConf(array $conf): void {
        $this->mlr = isset($conf['margin']) ? $conf['margin'] : $this->mlr;
        $this->showNumberRow = isset($conf['showNumberRow']) ? $conf['showNumberRow'] : $this->showNumberRow;
        $this->defaultSizeCol = isset($conf['defaultSizeCol']) ? $conf['defaultSizeCol'] : $this->defaultSizeCol;
    }
    /**
     * Create row from params
     * @param array $lines
     */
    private function setLines(array $lines): void {

        foreach ($lines as $key => $value){
            $isLast = $key + 1 === count($lines);
            $row = "";
            if($this->showNumberRow){
                array_unshift($value , $key + 1);
            }

            foreach ($value as $k => $v){
                $row .= $this->addToColumn($v, $k);
            }

            $separator = $isLast ? $this->separatorBorder : $this->separatorLine;
            $row .= "|\n$separator";
            $this->rowInString[] =  $row;
            $this->tableInString .= $row;
        }
    }

    /**
     * Show new line to the table.
     * @param string $txt
     * @param int $columnIndex
     * @return string
     */
    private function addToColumn(string $txt, int $columnIndex): string {
        $sizeColumn = $this->headerColumn[$columnIndex]['size'];
        $name = self::cutString($txt, $sizeColumn);
        $seperate = self::charGenerator(($sizeColumn - $this->lengthStr($name))," ");
        $marginChar = self::charGenerator($this->mlr," ");
        return "|" . $marginChar . $name . $seperate . $marginChar;
    }

    /**
     * Get real nombre char from string with ascii
     * @param $str
     * @return false|string
     */
    private function lengthStr($str){
        return  mb_strwidth(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $str));
    }
    /**
     * Cut a string is is too long.
     * @param string $str
     * @param int $maxLength
     * @return string
     */
    private function cutString(string $str, int $maxLength): string {
        $lengthStr = $this->lengthStr($str);
        return $lengthStr > $maxLength ? substr($str, 0, $maxLength) : $str;
    }

    /**
     * Return the lenght of the table.
     * Sum of each length column.
     * @param array $headerColumn
     * @return int
     */
    private function getLengthColumn(array $headerColumn): int{
        $length = 0;
        foreach ($headerColumn as $value){
            $length += $value['size'];
        }
        return $length + count($headerColumn) + ( ($this->mlr * 2) * count($headerColumn) + 1 );
    }

    /**
     * @param int $nbr
     * @param string $char
     * @return string
     */
    private static function charGenerator(int $nbr, string $char): string {
        $out = "";
        for ($i = 0; $i < $nbr; $i++){
            $out .= "$char";
        }
        return $out;
    }

    private function parseDataTitleColumns(array $columns): array {

        return array_map(function ($col, $key){

            // Not data for size in $columns data, set size.
            if(!isset($col['name']) && !isset($col['size'])){
                $col = [
                    'name' => $col,
                    'size' => $this->defaultSizeCol,
                    'SizeByGreatest' => true
                ];

                // The default size column is not set, get the longest str length from line or header title.
                if(!$this->defaultSizeCol){
                    $maxLengthLine = $this->getMaxLengthStr($this->lines[$key]);
                    $sizeHeader = mb_strwidth($col['name']);
                    $col['size'] = $maxLengthLine > $sizeHeader ? $maxLengthLine : $sizeHeader;
                }

            }
            return $col;
        }, $columns, array_keys($columns));
    }

    private function getMaxLengthStr(array $arr): int {
        return max(array_map('strlen', $arr));
    }

    private function separator($isBorder = false){
        $base =  self::charGenerator(self::getLengthColumn($this->headerColumn), "-") . "\n";;
        $char = $isBorder ? '+' : '|';

        $pos = 0;
        foreach ($this->headerColumn as $k => $v){
            $pos += $this->getSizeCol()[$k] + ($this->mlr * 2) + 1;
            $base[$pos] = $char;
        }

        return $string = preg_replace('/^.|.$/',$char,$base);
    }

    private function getSizeCol(){
        return array_map(function ($col){
            return $col['size'];
        }, $this->headerColumn);
    }
}




