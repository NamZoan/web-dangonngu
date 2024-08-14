<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Mailtrap\Config;
use Illuminate\Support\Facades\Response;

use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $layout = null;

    public $config = [];

    public $header = [];

    private $language = 'vi';
    /**
     * @Description : Hàm render 
     *
     * @throws 	: NotFoundException
     * @param 	: string $view , array $data
     * @return 	: view + layout
     * @Author 	: DRaja
     */


    public function render($view, $data = [])
    {

        // check URL 
        // if (!empty($this->header['canonical'])) {
        //     if (request()->root() . parse_url(request()->getRequestUri(), PHP_URL_PATH) != $this->header['canonical']) {
        //         return abort(404);
        //     }
        // }
        return view($this->layout, $this->config, $this->header)->with('content', view(
            $view,
            $data,
            [
                'language' => $this->language,
            ]
        ));
    }


    /**
     * @Description : send message to email address 
     *
     * @throws 	: NotFoundException
     * @param 	: $e : address , $subject : title , $content : content in HTML
     * @return 	: array json
     * @Author 	: DRaja
     */

    public function sendEmail($e, $subject, $content)
    {
        $apiKey = "263baabfa474c86b193c7624fac86113";
        $mailtrap = new MailtrapClient(new Config($apiKey));

        $email = (new Email())
            ->from(new Address('mailtrap@demomailtrap.com', 'Mailtrap Test'))
            ->to(new Address($e))
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->html($content);

        try {
            $response = $mailtrap->sending()->emails()->send($email);

            return Response::make(ResponseHelper::toArray($response));
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
