<?php 
/**
* 
*/
class PrintFormatter
{
    const AVAILABLE_CARACHTERS = 40;
    public $result = '';

    function __construct() {}

    public function text($text, $align = 'left', $newLine = true)
    {
        switch ($align) {
            case 'center':
                $this->textAlignCenter($text);
                break;
            case 'right':
                $this->textAlignRight($text);
                break;            
            default:
                $this->textAlignLeft($text);
                break;
        }

        if($newLine) $this->newLine();

        return $this;
    }

    public function textAlignLeft($text)
    {
        $this->result .= $text;
        return $this;
    }

    public function textAlignCenter($text, $availableCharachters = self::AVAILABLE_CARACHTERS)
    {
        $textLength = (int) strlen($text);
        $restOfTextLength = $availableCharachters - $textLength;
        $splitTextLength = $restOfTextLength/2;

        $this->createSpace($splitTextLength);
        $this->result .= $text;
        $this->createSpace($splitTextLength);
        return $this;
    }

    public function textAlignRight($text, $availableCharachters = self::AVAILABLE_CARACHTERS)
    {
        $textLength = (int) strlen($text);
        $restOfTextLength = $availableCharachters - $textLength;
        $this->createSpace($restOfTextLength);
        $this->result .= $text;
        return $this;
    }

    /**
     * @param  data
     * @return this
     *
     * array['label1' => 'value1', 'label2' => 'value2']
     */
    public function formFormats(array $data)
    {
        $maxlen = max(array_map('strlen', array_keys($data)));

        foreach ($data as $key => $value) 
            $this->formFormat($key, $value, $maxlen - strlen($key));

        return $this;
    }

    public function formFormat($lable, $text = '', $space = 1)
    {
        $this->text($lable, 'left', false);
        $this->createSpace($space);
        $this->text('  : '.$text);
        return $this;
    }

    public function createSpace($value = 1)
    {
        for ($i=0; $i < $value; $i++) $this->result .= Chr(32);
        return $this;
    }

    public function newLine()
    {
        $this->result .= "\n";
        return $this;
    }

    /**
     * @param  array
     * @return [type]
     * ['one', 'two', 'three']
     */
    public function table(array $data)
    {
        $cellWidth = self::AVAILABLE_CARACHTERS/count($data);
        foreach ($data as $key => $value) {
            $this->result .= $value;
            $space = $cellWidth - strlen($value);
            $this->createSpace($space);
        }

        $this->newLine();
        return $this;
    }

    /**
     * @param  array
     * @return [type]
     *
     * ['text' => 'Text value', 'align' => 'LEFT', 'width' => 0.5]
     */
    public function customTable(array $data)
    {
        $cellWidth = self::AVAILABLE_CARACHTERS/count($data);
        $secondLine = [];
        $secondLineEnabled = false;

        foreach ($data as $value) {
            $tooLong = false;
            if($value['width']) $cellWidth = self::AVAILABLE_CARACHTERS * $value['width'];

            // If text is too wide go to next line
            if($cellWidth < strlen($value['text'])){
                $tooLong = true;
                $value['originalText'] = $value['text'];
                $value['text'] = substr($value['text'], 0, $cellWidth);
            }

            if($value['align'] == "CENTER"){
                $this->textAlignCenter($value['text'], $cellWidth);
            } else if($value['align'] == "RIGHT") {
                $this->textAlignRight($value['text'], $cellWidth);
            } else {
                $this->textAlignLeft($value['text']);
                $spaces = $cellWidth - strlen($value['text']);
                $this->createSpace($spaces);
            }

            if($tooLong){
                $secondLineEnabled = true;
                $value['text'] = substr($value['originalText'], $cellWidth-1);
                $secondLine[] = $value;
            } else {
                $value['text'] = "";
                 $secondLine[] = $value;
            }
        }

        $this->newLine();

        if($secondLineEnabled){
            $this->customTable($secondLine);
        }

        return $this;
    }

    public function line($type = 'single', $newLine = true)
    {
        switch ($type) {
            case 'double':
                $this->doubleLine();
                break;

            case 'underscore':
                $this->underscoreLine();
                break;
            
            default:
                $this->singeLine();
                break;
        }

        if($newLine) $this->newLine();

        return $this;
    }

    public function singeLine()
    {
        $this->generateLine('-');
        return $this;
    }

    public function doubleLine()
    {
        $this->generateLine('=');
        return $this;
    }

    public function underscoreLine()
    {
        $this->generateLine('_');
        return $this;
    }

    public function generateLine($text)
    {
        for ($i=0; $i < self::AVAILABLE_CARACHTERS; $i++)
            $this->result .= $text;
        return $this;
    }

    public function generate()
    {
        return $this->result;
    }
}