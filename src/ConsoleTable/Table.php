<?php

namespace ConsoleTable;

class Table
{
    private $dataColumn = [];
    private $separatorLine = "";
    private $mlr = 1; // number character margin into column.
    private $showNumberRow = true; // shwo number row.
    private $tableInString = "";
    private $rowInString = [];
    private $columnTitleString = [];
    private $defaultSizeCol = 30;

    public function __construct(array $dataColumn, array $lines, array $conf = [])
    {
        //Conf
        $this->setConf($conf);

        $dataColumn = $this->parseDataTitleColumns($dataColumn);
        if($this->showNumberRow){
            array_unshift($dataColumn, ['name' => 'Row', 'size' => 4]);
        }


        $this->dataColumn = $dataColumn;
        $this->separatorLine = self::charGenerator(self::getLengthColumn($dataColumn), "-") . "\n";;
        self::setColumnTitle($dataColumn);
        self::setLines($lines);
    }

    /**
     * Show all row of table.
     */
    public function show(){
        echo $this->tableInString;
    }

    /**
     * Show one specific row.
     * @param int $row
     */
    public function showRow(int $row){
        echo $this->columnTitleString;
        echo $this->rowInString[$row - 1];
    }

    /**
     * Create column with title.
     * @param array $dataColumn
     */
    private function setColumnTitle(array $dataColumn): void{
        $this->tableInString .= $this->separatorLine;
        $columnString = "";
        foreach ($dataColumn as $key => $value){
            $columnString .= $this->addToColumn($value['name'], $key);
        }
        $columnString .= "|\n$this->separatorLine";
        $this->tableInString .= $columnString;
        $this->columnTitleString = $this->separatorLine.$columnString;
    }

    private function setConf(array $conf){
        $this->mlr = isset($conf['margin']) ? $conf['margin'] : $this->mlr;
        $this->showNumberRow = isset($conf['showNumberRow']) ? $conf['showNumberRow'] : $this->showNumberRow;
        $this->defaultSizeCol = isset($conf['defaultSizeCol']) ? $conf['defaultSizeCol'] : $this->defaultSizeCol;
    }
    /**
     * Create row from params
     * @param array $lines
     */
    private function setLines(array $lines){
        foreach ($lines as $key => $value){
            $row = "";
            if($this->showNumberRow){
                array_unshift($value , $key + 1);
            }

            foreach ($value as $k => $v){
                $row .= $this->addToColumn($v, $k);
            }

            $row .= "|\n$this->separatorLine";

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
        $sizeColumn = $this->dataColumn[$columnIndex]['size'];
        $name = self::cutString($txt, $sizeColumn);
        $seperate = self::charGenerator(($sizeColumn - mb_strlen($name))," ");
        $marginChar = self::charGenerator($this->mlr," ");
        return "|" . $marginChar . $name . $seperate . $marginChar;;
    }

    /**
     * Cut a string is is too long.
     * @param string $str
     * @param int $maxLength
     * @return string
     */
    private static function cutString(string $str, int $maxLength): string {
        $lengthStr = mb_strlen($str);
        return $lengthStr > $maxLength ? substr_replace($str, "", $maxLength - $lengthStr) : $str;
    }

    /**
     * Return the lenght of the table.
     * Sum of each length column.
     * @param array $dataColumn
     * @return int
     */
    private function getLengthColumn(array $dataColumn): int{
        $length = 0;
        foreach ($dataColumn as $value){
            $length += $value['size'];
        }
        return $length + count($dataColumn) + ( ($this->mlr * 2) * count($dataColumn) + 1 );
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

    private function parseDataTitleColumns(array $columns){
        return array_map(function ($col){
            if(!isset($col['name']) && !isset($col['size'])){
                $col = [
                    'name' => $col,
                    'size' => $this->defaultSizeCol,
                ];
            }
            return $col;
        }, $columns);
    }
}




