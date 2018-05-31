<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/1/13
 * Time: 下午5:18
 */


class GameHandler extends BaseHandler {


    public function HandlerRequest(BaseRequest $request)
    {
        if ($request->action == "game") {
            echo "game [data]" . $request->data . "\n";
        } elseif ($this->nexHandler)
            $this->nexHandler->HandlerRequest($request);
        else
            echo "action is error!\n";
    }


}