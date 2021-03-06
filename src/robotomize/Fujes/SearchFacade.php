<?php
    /**
     * This file is part of the Fujes package.
     * @link    https://github.com/robotomize/fujes
     * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
     */

namespace robotomize\Fujes;

/**
 * Class FacadeJsonSearch
 * It's just a facade for the main class.
 * I think the use of such an interface is much simpler, however,
 * have the option of using factory or techniques to deal with directly.
 *
 * @package robotomize\Fujes
 * @author  robotomize@gmail.com
 * @version 0.4.1.0
 */
class SearchFacade
{

    /**
     * @var string
     */
    private $urlName = '';

    /**
     * @var string
     */
    private $matchString = '';

    /**
     * @var int
     */
    private $depth;

    /**
     * @var
     */
    private $jsonEncode;

    /**
     * @var boolean
     */
    private $multipleResult;

    /**
     * @var int
     */
    private $quality;

    /**
     * @var string
     */
    private $versionType = '';

    /**
     * @var string
     */
    private static $version = '0.4.1.0';

    /**
     * Facade constructor
     * The first option writes in logs all exceptions and successful search.
     *
     * @param $urlName
     * @param $matchString
     * @param int $depth
     * @param bool $jsonEncode
     * @param bool $multipleResult
     * @param int $quality
     * @param string $versionType
     */
    public function __construct(
        $urlName,
        $matchString,
        $depth = 1,
        $jsonEncode = true,
        $multipleResult = false,
        $quality = 1,
        $versionType = 'master'
    ) {
        if ($urlName == '' || $matchString == '') {
            throw new \InvalidArgumentException;
        } else {
            $this->urlName = $urlName;
            $this->matchString = mb_strtolower($matchString);
            $this->depth = $depth;
            $this->jsonEncode = $jsonEncode;
            $this->multipleResult = $multipleResult;
            $this->quality = $quality;
            $this->versionType = $versionType;
        }
    }

    /**
     * @return SearchEngine
     */
    private function create()
    {
        return new SearchEngine(
            $this->urlName,
            $this->matchString,
            $this->depth,
            $this->jsonEncode,
            $this->multipleResult,
            $this->quality,
            $this->versionType
        );
    }

    /**
     * @return SearchEngine
     */
    private function getInstance()
    {
        $search = $this->create();
        $search->run();

        return $search;
    }

    /**
     * Get only relevant search results.
     * @TODO facade shared jsonTree, + 100% acceleration
     *
     * @return string
     */
    public function fetchOne()
    {
        return $this->getInstance()->fetchOne();
    }

    /**
     * Get a set of search results, specify the number yourself.
     *
     * @param int $count
     *
     * @return array
     */
    public function fetchFew($count)
    {
        return $this->getInstance()->fetchFew($count);
    }

    /**
     * Get all search results
     * @TODO fetch all filtered, array filtered
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->getInstance()->fetchAll();
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        return $this->fetchOne();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->jsonEncode == false) {
            return serialize($this->fetchOne());
        } else {
            return $this->fetchOne();
        }
    }

    /**
     * @return string
     */
    public function getUrlName()
    {
        return $this->urlName;
    }

    /**
     * @param string $urlName
     */
    public function setUrlName($urlName)
    {
        $this->urlName = $urlName;
    }

    /**
     * @return string
     */
    public function getMatchString()
    {
        return $this->matchString;
    }

    /**
     * @param string $matchString
     */
    public function setMatchString($matchString)
    {
        $this->matchString = $matchString;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getJsonEncode()
    {
        return $this->jsonEncode;
    }

    /**
     * @param mixed $jsonEncode
     */
    public function setJsonEncode($jsonEncode)
    {
        $this->jsonEncode = $jsonEncode;
    }

    /**
     * @return boolean
     */
    public function getMultipleResult()
    {
        return $this->multipleResult;
    }

    /**
     * @param boolean $resultsCount
     */
    public function setMultipleResult($resultsCount)
    {
        $this->multipleResult = $resultsCount;
    }

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param int $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    /**
     * @return string
     */
    public function getVersionType()
    {
        return $this->versionType;
    }

    /**
     * @param string $versionType
     */
    public function setVersionType($versionType)
    {
        $this->versionType = $versionType;
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return self::$version;
    }
}
