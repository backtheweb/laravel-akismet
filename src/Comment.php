<?php
namespace Backtheweb\Akismet;

use Backtheweb\Akismet\Exception\AkismetException;

abstract class Comment implements AkismetCommentInterface
{

    /** @var string */
    protected $blog;

    /** @var   */
    protected $userIp;

    /** @var   */
    protected $userAgent;

    /** @var   */
    protected $referrer;

    /** @var   */
    protected $permalink;

    /** @var   */
    protected $locale;

    /** @var string  */
    protected $charset = 'UTF-8';

    /** @var bool  */
    protected $test = false;

    /** @var string  */
    protected $commentType;

    /** @var   */
    protected $commentAuthorName;

    /** @var  string */
    protected $commentAuthorEmail;

    /** @var  string */
    protected $commentAuthorUrl;

    /** @var  string */
    protected $commentContent;


    /** @var  string | datetime */
    protected $commentDateGmt;

    /** @var  string | datetime */
    protected $commentPostModifiedGmt;


    /**
     * @return mixed
     */
    public function getCommentType() : string
    {
        return $this->commentType;
    }

    /**
     * @param mixed $commentType
     * @return Akismet
     */
    public function setCommentType($commentType)
    {
        $this->commentType = $commentType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentAuthor() : string
    {
        return $this->commentAuthor;
    }

    /**
     * @param mixed $commentAuthor
     * @return Akismet
     */
    public function setCommentAuthor($commentAuthor)
    {
        $this->commentAuthor = $commentAuthor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentAuthorEmail() : string
    {
        return $this->commentAuthorEmail;
    }

    /**
     * @param $email
     * @return $this
     * @throws AkismetException
     */
    public function setCommentAuthorEmail($email)
    {
        if( filter_var($email, FILTER_VALIDATE_EMAIL) === false ) {
            throw new AkismetException('Akismet: Invalid author email');
        }

        $this->commentAuthorEmail = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentAuthorUrl() : string
    {
        return $this->commentAuthorUrl;
    }

    /**
     * @param $url
     * @return $this
     * @throws AkismetException
     */
    public function setCommentAuthorUrl($url)
    {
        if( filter_var($url, FILTER_VALIDATE_URL) === false ) {
            throw new AkismetException('Akismet: Invalid author url');
        }

        $this->commentAuthorUrl = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentContent() : string
    {
        return $this->commentContent;
    }

    /**
     * @param mixed $commentContent
     * @return Akismet
     */
    public function setCommentContent($commentContent)
    {
        $this->commentContent = $commentContent;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getUserIp() : string
    {
        if($this->userIp === null){

            $ip = \Request::ip();

            $this->setUserIp($ip);
        }

        return $this->userIp;
    }

    /**
     * @param $ip
     * @return $this
     */
    public function setUserIp($ip)
    {
        if( filter_var($ip, FILTER_VALIDATE_IP) === false ) {
            throw new AkismetException('Akismet: Invalid ip');
        }

        $this->userIp = $ip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserAgent() : string
    {

        if($this->userAgent === null){

            $agent  = request()->header('User-Agent');

            $this->setUserAgent($agent);
        }

        return $this->userAgent;
    }

    /**
     * @param $userAgent
     * @return string
     */
    public function setUserAgent($userAgent) : string
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferrer() : string
    {
        if(null === $this->referrer){

            //$this->setReferrer(filter_input(INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_URL));
            $this->setReferrer(\URL::previous());
        }

        return $this->referrer;
    }

    /**
     * @param $referrer
     * @return string
     */
    public function setReferrer($referrer) : string
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPermalink() : string
    {
        return $this->permalink;
    }

    /**
     * @param mixed $permalink
     * @return Akismet
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isTest(): bool
    {
        return $this->test;
    }

    /**
     * @param boolean $test
     * @return Akismet
     */
    public function setTest(bool $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale () : string
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     * @return Akismet
     */
    public function setLocale ($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getCharset (): string
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return Akismet
     */
    public function setCharset (string $charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlog(): string
    {
        return $this->blog;
    }

    /**
     * @param string $blog
     */
    public function setBlog(string $blog)
    {
        $this->blog = $blog;
    }

    /**
     * @return mixed
     */
    public function getCommentAuthorName() : string
    {
        return $this->commentAuthorName;
    }

    /**
     * @param mixed $commentAuthorName
     */
    public function setCommentAuthorName($commentAuthorName)
    {
        $this->commentAuthorName = $commentAuthorName;
    }

    /**
     * @return datetime|string
     */
    public function getCommentDateGmt()
    {
        return $this->commentDateGmt;
    }

    /**
     * @param datetime|string $commentDateGmt
     */
    public function setCommentDateGmt($commentDateGmt)
    {
        $this->commentDateGmt = $commentDateGmt;
    }

    /**
     * @return datetime|string
     */
    public function getCommentPostModifiedGmt()
    {
        return $this->commentPostModifiedGmt;
    }

    /**
     * @param datetime|string $commentPostModifiedGmt
     */
    public function setCommentPostModifiedGmt($commentPostModifiedGmt)
    {
        $this->commentPostModifiedGmt = $commentPostModifiedGmt;
    }

    /**
     * @return array
     */
    public function toAkismetArray() : array
    {
        return [

            // Mandatory
            'blog'                      => $this->getBlog(),
            'user_ip'                   => $this->getUserIp(),
            'user_agent'                => $this->getUserAgent(),
            'referrer'                  => $this->getReferrer(),
            'permalink'                 => $this->getPermalink(),
            'comment_type'              => $this->getCommentType(),
            'comment_author'            => $this->getCommentAuthor(),
            'comment_author_email'      => $this->getCommentAuthorEmail(),
            'comment_author_url'        => $this->getCommentAuthorUrl(),
            'comment_content'           => $this->getCommentContent(),

            // Optional

            'blog_lang '                => $this->getLocale(),
            'is_test'                   => $this->isTest(),
            'blog_charset'              => $this->getCharset(),
            'comment_date_gmt'          => $this->getCommentDateGmt(),
            'comment_post_modified_gmt' => $this->getCommentPostModifiedGmt(),
        ];
    }
}