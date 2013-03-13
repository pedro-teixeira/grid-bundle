<?php

namespace PedroTeixeira\Bundle\GridBundle\Grid\Render;

/**
 * Render YesNo
 */
class YesNo extends RenderAbstract
{
    /**
     * @var bool
     */
    protected $showYes = true;

    /**
     * @var bool
     */
    protected $showNo = true;

    /**
     * @return string
     */
    public function render()
    {
        if ($this->getValue() && $this->getShowYes()) {
            return '<i class="icon-ok"></i>';
        } else if ($this->getShowNo()) {
            return '<i class="icon-remove"></i>';
        }

        return null;
    }

    /**
     * @param bool $showNo
     *
     * @return YesNo
     */
    public function setShowNo($showNo)
    {
        $this->showNo = $showNo;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowNo()
    {
        return $this->showNo;
    }

    /**
     * @param bool $showYes
     *
     * @return YesNo
     */
    public function setShowYes($showYes)
    {
        $this->showYes = $showYes;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowYes()
    {
        return $this->showYes;
    }
}