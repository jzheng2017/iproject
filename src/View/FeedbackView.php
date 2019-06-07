<?php


namespace EenmaalAndermaal\View;


class FeedbackView extends View
{
    public $voorwerp;
    public $feedback;
    public $commentaar;
    public $dag;
    public $tijd;
    public $access;
    public function __construct()
    {
        parent::__construct("veilingen/feedback");
        $this->homepage = false;
        $this->access = false;
        $this->addStyle("style/feedback");
        $this->addScript("scripts/user/feedback");
    }
}