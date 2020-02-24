<?php

namespace ConsoleTable;


class Readline{

    private $answer = "";

    public function __construct(string $txt, array $availableParams = [], int $defaultValueIndex = -1)
    {
        $activeParams = count($availableParams) > 0;

        if($defaultValueIndex >= 0 && $defaultValueIndex > count($availableParams)){
            throw new \Exception("invalid defaultValueIndex params !\n");
            return;
        }

        // Upper default value params if is active.
        if($activeParams && $defaultValueIndex >= 0){
            $availableParams[$defaultValueIndex] = strtoupper($availableParams[$defaultValueIndex]);
        }

        $txt = $activeParams ? $txt .= " (". implode('/', $availableParams) . ")" : $txt;

        echo $txt .= "\n";
        $this->answer = readline("> ");


        if($activeParams){
            if(strlen($this->answer) === 0 && $defaultValueIndex >= 0){
                $this->answer = $availableParams[$defaultValueIndex];
            }elseif (array_search($this->answer, $availableParams) === false){
                $result = new Readline("The answer $this->answer is invalid, please enter valid value", $availableParams, $defaultValueIndex);
                $this->answer = $result->getAnswer();
            }

        }

        return $this;
    }

    public function getAnswer(){
        return $this->answer;
    }

}
