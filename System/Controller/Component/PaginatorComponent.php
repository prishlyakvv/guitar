<?php
//todo вынести в отдельный плагин со встроеными плюшками
namespace System\Controller\Component;


use System\Controller\MainComponent;
use System\App;

class PaginatorComponent extends MainComponent {

    protected $_params = array();

    protected $_page = 0;
    protected $_count = 0;
    protected $_limits = array(5, 24, 48, 96);
    protected $_currLimit = 24;

    protected $_from = 0;
    protected $_to = 0;

    protected $_template = 'System/paginator.html';

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->_from;
    }

    /**
     * @param int $from
     */
    public function setFrom($from)
    {
        $this->_from = $from;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->_to;
    }

    /**
     * @param int $to
     */
    public function setTo($to)
    {
        $this->_to = $to;
    }


    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->_page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->_page = $page;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->_count = $count;
    }


    protected function initialize() {

        $controller = $this->getController();
        $page = $controller->getRequestParam('page', 0);
        $this->setPage($page);

        $currLimit = $controller->getRequestParam('limit', 0);

        if (!in_array($currLimit, $this->getLimits())) {
            $currLimit = array_shift($this->getLimits());
        }
        $this->setCurrLimit($currLimit);

        $this->_params = $controller->getRequestAll();
    }

    protected function run() {

        $countPages = ceil($this->getCount() / $this->getCurrLimit());

        $page = $this->getPage();
        if ($page > $countPages || $page < 1) {
            $this->setPage(1);
        }

        $from = ($this->getPage() - 1) * $this->getCurrLimit();
        $this->setFrom($from);

        $to = $this->getFrom() + $this->getCurrLimit() - 1;
        $this->setTo($to);

        $pages = array();
        for ($i=1; $i<=$countPages; $i++) {
            $pages[] = $i;
        }

        $paramsArr = $this->_params;
        $params = App::getInstance()->getRouter()->getCurrentPath() . '?';

        if ($paramsArr) {
            if (isset($paramsArr['page'])) {
                unset($paramsArr['page']);
            }
            if (isset($paramsArr['limit'])) {
                unset($paramsArr['limit']);
            }

            $i = 0;
            foreach ($paramsArr as $key => $value) {
                $params .= ($i == 0) ? '' : '&';
                $params .= $key . '=' . $value;
                $i++;
            }
        }

        return $this->render(array(
            'limites' => $this->getLimits(),
            'curLimit' => $this->getCurrLimit(),
            'page' => $this->getPage(),
            'pages' => $pages,
            'url' => $params,
        ), $this->getTemplate());
    }


    /**
     * @return array
     */
    public function getLimits()
    {
        return $this->_limits;
    }

    /**
     * @param array $limits
     */
    public function setLimits($limits)
    {
        $this->_limits = $limits;
    }

    /**
     * @return int
     */
    public function getCurrLimit()
    {
        return $this->_currLimit;
    }

    /**
     * @param int $currLimit
     */
    public function setCurrLimit($currLimit)
    {
        $this->_currLimit = $currLimit;
    }

} 
