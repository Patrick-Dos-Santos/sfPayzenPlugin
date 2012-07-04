<?php

class sfPayzenReturnTestActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->form = new sfPayzenPaymentReturnForm();
    }
    
    public function executeSumUp(sfWebRequest $request)
    {
        $this->form = new sfPayzenPaymentReturnForm();
    }
}