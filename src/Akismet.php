<?php
namespace Backtheweb\Akismet;

use App\Post;
use GuzzleHttp\Client;

use Backtheweb\Akismet\Exception\AkismetCredentialsException;

class Akismet {

    const API_VERSION = '1.1';
    const API_URL     = 'rest.akismet.com';

    /** @var  Client */
    protected $client;

    /** @var   */
    protected $key;

    /** @var   */
    protected $site;

    public function __construct($key, $site)
    {
        $this->key  = $key;
        $this->site = $site;
        $this->site = $site;
        $valid      = $this->validateKey();

        if(!$valid){

            throw new AkismetCredentialsException();
        }
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if(null === $this->client){

            $this->client = new Client();
        }

        return $this->client;
    }

    protected function getApiUrl($action)
    {

        switch($action){

            case 'verify-key': $url = sprintf('https://%s/%s/verify-key', self::API_URL, self::API_VERSION);            break;
            default:           $url = sprintf('https://%s.%s/%s/%s',         $this->key, self::API_URL, self::API_VERSION,  $action);
        }

        return $url;
    }

    /**
     * @return bool
     */
    public function validateKey()
    {
        $requestOption = $this->getRequestOption();

        $response   = $this->getClient()->post($this->getApiUrl('verify-key'), [$requestOption => [
            'key'   => $this->key,
            'blog'  => $this->site,
        ]]);

        return (bool) ($response->getBody() == 'valid');
    }

    /**
     * isSpam
     * @return bool
     */
    public function isSpam(AkismetDataInterface $obj)
    {
        $response = $this->getResponseData($this->getApiUrl('comment-check'), $obj);

        return (bool) (trim($response->getBody()) == 'true');
    }

    /**
     * reportSpam
     * @return bool
     */
    public function reportSpam(AkismetDataInterface $obj)
    {
        $response = $this->getResponseData($this->getApiUrl('submit-spam'), $obj);

        return (bool) (trim($response->getBody()) == 'Thanks for making the web a better place.');
    }

    /**
     * reportHam
     * @return bool
     */
    public function reportHam(AkismetDataInterface $obj)
    {
        $response = $this->getResponseData($this->getApiUrl('submit-ham'), $obj);

        return (bool) (trim($response->getBody()) == 'Thanks for making the web a better place.');
    }

    /**
     * @param $url
     * @throws \Exception
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    private function getResponseData($url, AkismetDataInterface $obj)
    {
        $data           = $this->dataToArray($obj);
        $requestOption  = $this->getRequestOption();
        $request        = $this->getClient()->post($url, [$requestOption => $data]);

        // Check if the response contains a X-akismet-debug-help header
        if($request->getHeader('X-akismet-debug-help')){

            throw new \AkismetException($request->getHeader('X-akismet-debug-help'));
        }

        return $request;
    }

    /**
     * @return string
     */
    private function getRequestOption()
    {
        return (version_compare(\GuzzleHttp\ClientInterface::VERSION, '6.0.0', '<')) ? 'body' : 'form_params';
    }

    public function dataToArray(AkismetDataInterface $obj)
    {
        return [

            // Mandatory
            'blog'                      => $obj->getBlog(),
            'user_ip'                   => $obj->getUserIp(),
            'user_agent'                => $obj->getUserAgent(),
            'referrer'                  => $obj->getReferrer(),
            'permalink'                 => $obj->getPostPermalink(),
            'comment_type'              => $obj->getCommentType(),
            'comment_author'            => $obj->getCommentAuthor(),
            'comment_author_email'      => $obj->getCommentAuthorEmail(),
            'comment_author_url'        => $obj->getCommentAuthorUrl(),
            'comment_content'           => $obj->getCommentContent(),

            // Optional

            'blog_lang '                => $obj->getBlogLang(),
            'is_test'                   => $obj->isTest(),
            'blog_charset'              => $obj->getCharset(),
            'comment_date_gmt'          => $obj->getCommentDateGmt(),
            'comment_post_modified_gmt' => $obj->getCommentPostModifiedGmt(),
        ];
    }
}
