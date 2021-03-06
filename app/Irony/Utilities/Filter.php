<?php namespace Irony\Utilities;

use Config, Cache;

/**
 * Class Filter
 * Filters out profanity
 * @package Irony\Utilities
 */
class Filter
{
    /**
     * Limits amount of phrases per RegExp
     * @var integer
     */
    protected $wordsPerExp = 80;

    /**
     * Array of Regular Expressions to Check
     * @var array
     */
    protected $regExps;

    /**
     * Array of words grabbed from Config
     * @var array
     */
    protected $words;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->words = Config::get('profane.words');
        $this->fetchRegExps();
    }

    /**
     * @param $string
     * @param string $replacement
     * @return string
     */
    public function filter($string, $replacement = '')
    {
        $string = strtolower($string);

        foreach ($this->regExps as $regExp) {
            $string = preg_replace($regExp, $replacement, $string);
        }


        return ucsentence($string);
    }

    /**
     * Grab expressions from cash or create them
     */
    protected function fetchRegExps()
    {
        // Check if we are caching.
        if (Config::get('profane.cached')) {
            $this->getCachedRegExps();
        } else {
            $this->createRegExps();
        }
    }

    protected function getCachedRegExps()
    {
        if (Cache::has('profane.regExps')) {
            $this->regExps = Cache::get('profane.regExps');
        } else {
            $this->createRegExps();
        }
    }

    protected function createRegExps()
    {
        $this->regExps = array();

        $regExp = '/\b';
        for ($i=0; $i < count($this->words); $i++) {
            $word = $this->words[$i];
            $regExp .= $word;
            if ($i % $this->wordsPerExp == 0 && $i != 0) {
                $regExp .= '\b/';
                $this->regExps[] = $regExp;
                $regExp = '/\b';
            } else {
                $regExp .= '|';
            }
        }
        if ($regExp == '/\b/(') {
            $regExp .= ')\b/g';
            $this->regExps[] = $regExp;
        }

        if (Config::get('profane.cached')) {
            Cache::forever('profane.regExps', $this->regExps);
        }
    }
}