<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/18
 * Time: 15:59
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Render;

use Symfony\Component\HttpFoundation\Response;

class JavascriptRender
{
    protected $content;

    /**
     * @var $response \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    protected $headStyle = [];

    protected $footerScript = [];

    public function __construct(Response $response)
    {
        $this->content  = $response->getContent();
        $this->response = $response;
    }

    public function renderPurpleButton()
    {
        $this->renderHead();
        $this->renderFooter();
    }

    protected function getHeadPos()
    {
        return stripos($this->content, '</head>');
    }

    protected function getFootPos()
    {
        return stripos($this->content, '</body>');
    }

    protected function renderHead()
    {
        if (false !== $this->getHeadPos()) {
            $styleHtml = "";
            foreach ($this->headStyle as $style) {
                $styleHtml .= sprintf('<link href="%s" rel="stylesheet" />', $style) . "\n";
            }
            $content   = substr($this->content, 0, $this->getHeadPos()) . $styleHtml . substr($this->content, $this->getHeadPos());
            $this->response->setContent($content);
        }
    }

    protected function renderFooter()
    {
        if (false !== $this->getFootPos()) {
            $scriptHtml = "";
            foreach ($this->footerScript as $script) {
                $scriptHtml .= sprintf('<script type="text/javascript" src="%s"></script>', $script) . "\n";
            }
            $content    = substr($this->content, 0, $this->getFootPos()) . $scriptHtml . substr($this->content, $this->getFootPos());
            $this->response->setContent($content);
        }
    }

}