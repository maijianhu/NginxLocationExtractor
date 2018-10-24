<?php
class NginxLocationExtractor
{
    protected $config;
    protected $configLength;
    protected $pos = 0;
    protected $locations = [];
    protected $currentLocation;
    protected $state;
    protected $inQuotes;
    protected $quote;
    protected $nestCount = 0;
    const STATE_FIND_LOCATION = 1;
    const STATE_FIND_MODIFIER = 2;
    const STATE_FIND_URI = 3;
    const STATE_FIND_CONTENT = 4;

    public function __construct(string $config = '')
    {
        $this->config = $config;
        $this->configLength = strlen($config);
        $this->state = self::STATE_FIND_LOCATION;
    }

    /**
     * extract location configs
     * @return array
     */
    public function extract()
    {
        while ($this->pos < $this->configLength) {
            switch ($this->state) {

                // find location directive without comment sign
                case self::STATE_FIND_LOCATION:
                    $this->pos ++;
                    $locationPos = strpos($this->config, 'location', $this->pos);
                    if ($locationPos !== false) {
                        $beforeString = substr($this->config, $this->pos - 1, $locationPos - $this->pos + 1);
                        $lines = preg_split('/[\r|\n|\r\n]/', $beforeString);
                        $lastLine = $lines[count($lines) - 1];
                        $this->pos = $locationPos + 8;
                        if (strpos($lastLine, '#') === false) {
                            $this->currentLocation = [];
                            $this->state = self::STATE_FIND_MODIFIER;
                        }
                    }
                    break;

                // find location modifier
                case self::STATE_FIND_MODIFIER:
                    $str = $this->config[$this->pos];
                    if (trim($str) !== '') {
                        $nextStr = $this->config[$this->pos + 1] ?? '';
                        $doubleStr = $str . $nextStr;
                        if (in_array($doubleStr, ['~*', '^~'])) {
                            $this->pos ++;
                            $this->currentLocation['modifier'] = $doubleStr;
                        } elseif (in_array($str, ['=', '~'])) {
                            $this->currentLocation['modifier'] = $str;
                        } else {
                            $this->pos --;
                            $this->currentLocation['modifier'] = '';
                        }
                        $this->state = self::STATE_FIND_URI;
                    }
                    $this->pos ++;
                    break;

                // find location uri
                case self::STATE_FIND_URI:
                    $str = $this->config[$this->pos];
                    if (trim($str) !== '') {
                        $startPos = $this->pos;
                        while ($this->pos < $this->configLength) {
                            $char = $this->config[$this->pos];
                            $this->switchQuoteState($char);
                            if (!$this->inQuotes && $char === '{' && $this->config[$this->pos - 1] !== '\\') {
                                $this->currentLocation['uri'] = trim(substr($this->config, $startPos, $this->pos - $startPos));
                                $this->state = self::STATE_FIND_CONTENT;
                                break;
                            }
                            $this->pos ++;
                        }
                    }
                    $this->pos ++;
                    break;

                // find location content
                case self::STATE_FIND_CONTENT:
                    $startPos = $this->pos;
                    while ($this->pos < $this->configLength) {
                        $char = $this->config[$this->pos];
                        $this->switchQuoteState($char);
                        if (!$this->inQuotes && $char === '{' && $this->config[$this->pos - 1] !== '\\') {
                            $this->nestCount ++;
                        }
                        if (!$this->inQuotes && $char === '}' && $this->config[$this->pos - 1] !== '\\') {
                            if ($this->nestCount) {
                                $this->nestCount --;
                            } else {
                                $this->currentLocation['content'] = substr($this->config, $startPos, $this->pos - $startPos);
                                $this->locations[] = $this->currentLocation;
                                $this->currentLocation = [];
                                $this->state = self::STATE_FIND_LOCATION;
                                break;
                            }
                        }
                        $this->pos ++;
                    }
                    break;
            }
        }

        return $this->locations;
    }

    /**
     * switch in quotes state by char
     * @param $str
     * @return bool|null
     */
    public function switchQuoteState($str)
    {
        if ($this->isQuote($str)) {
            if (!$this->quote) {
                $this->quote = $str;
                $this->inQuotes = true;
            } else {
                $this->inQuotes = $this->quote !== $str;
                if (!$this->inQuotes) {
                    $this->quote = null;
                }
            }
        }
        return $this->inQuotes;
    }

    /**
     * check if a char is quote sign
     * @param $str
     * @return bool
     */
    public function isQuote($str)
    {
        return $str === '"' || $str === "'";
    }
}

//$e = new NginxLocationExtractor($config);
//print_r($e->extract());