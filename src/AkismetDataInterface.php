<?php

namespace Backtheweb\Akismet;

interface AkismetDataInterface
{
    const COMMENT_TYPE_COMMENT      = 'comment';        // A blog comment.
    const COMMENT_TYPE_FORUM_POST   = 'forum-post';     // A top-level forum post.
    const COMMENT_TYPE_REPLY        = 'reply';          // A reply to a top-level forum post.
    const COMMENT_TYPE_BLOG_POST    = 'blog-post';      // A blog post.
    const COMMENT_TYPE_CONTACT_FORM = 'contact-form';   // A contact form or feedback form submission.
    const COMMENT_TYPE_SIGNUP       = 'signup';         // A new user account.
    const COMMENT_TYPE_MESSAGE      = 'message';        // A message sent between just a few users.

    public function getUserIp() : string;

    public function getUserAgent() : string;

    public function getReferrer() : string;

    public function getPostPermalink() : string;

    public function getBlog() : string;

    public function getBlogLang() : string;

    public function getCharset() : string;

    public function isTest() : bool;

    public function getCommentType() :  string;

    public function getCommentAuthor() :  string;

    public function getCommentAuthorEmail() : string;

    public function getCommentAuthorUrl() : string;

    public function getCommentContent() : string;

    public function getCommentDateGmt() : string;

    public function getCommentPostModifiedGmt() : string;

}