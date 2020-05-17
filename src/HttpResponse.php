<?php

namespace Ajuchacko\Payu;

use Symfony\Component\HttpFoundation\Response;

class HttpResponse
{
    /**
     * Creates new instance of Response and invokes
     * 
     * @param  array  $params
     * @param  string $payment_url
     * @return Symfony\Component\HttpFoundation\Response
     */
    public static function make(array $params, $payment_url)
    {
        return (new self())->__invoke($params, $payment_url);
    }

    /**
     * Creates new Http response to submit
     * 
     * @param  array  $params
     * @param  string $payment_url 
     * @return Symfony\Component\HttpFoundation\Response;
     */
    public function __invoke(array $params, string $payment_url)
    {
        $params = array_map(function ($param) {
            return htmlentities($param, ENT_QUOTES, 'UTF-8', false);
        }, $params);

        $output = sprintf('<form id="payment_form" method="POST" action="%s">', $payment_url);

        foreach ($params as $key => $value) {
            $output .= sprintf('<input type="hidden" name="%s" value="%s" />', $key, $value);
        }

        $output .= '<input type="hidden" name="service_provider" value="payu_paisa" size="64" />';

        $output .= '<div id="redirect_info" style="display: none">Redirecting...</div>
                <input id="payment_form_submit" type="submit" value="Proceed to PayUMoney" />
            </form>
            <script>
                document.getElementById(\'redirect_info\').style.display = \'block\';
                document.getElementById(\'payment_form_submit\').style.display = \'none\';
                document.getElementById(\'payment_form\').submit();
            </script>';

        return Response::create($output, 200, [
            'Content-type' => 'text/html; charset=utf-8',
        ])->send();
    }
}
