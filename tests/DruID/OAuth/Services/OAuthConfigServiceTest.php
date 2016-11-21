<?php namespace Genetsis\tests\OAuth\Services;

use Genetsis\core\OAuth\Services\OAuthConfig;
use PHPUnit\Framework\TestCase;

class OAuthConfigServiceTest extends TestCase
{

    public function testBuildFromXml_v1_4()
    {
        $oauth_config = new OAuthConfig();

        $config = $oauth_config->buildConfigFromXml($this->getXmlExample_v1_4(), '1.4');
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\Config', $config);

        $this->assertEquals('XXXXXXX', $config->getClientId());

        $this->assertEquals('YYYYYYY', $config->getClientSecret());

        $this->assertCount(2, $config->getHosts());
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\Host', $config->getHost('my-host-2'));
        $this->assertEquals('//www.foo-host-2.com', $config->getHost('my-host-2')->getUrl());

        $this->assertCount(5, $config->getRedirects());
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\RedirectUrl', $config->getRedirect('postLogin'));
        $this->assertEquals('http://www.foo.com/actions', $config->getRedirect('postLogin')->getUrl());

        $this->assertCount(3, $config->getEntryPoints()['entry_points']);
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\EntryPoint', $config->getEntryPoint('2222222-main'));
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\EntryPoint', $config->getEntryPoint());
        $this->assertEquals('2222222-main', $config->getEntryPoint('2222222-main')->getId());
        $this->assertEquals('1111111-main', $config->getEntryPoint()->getId());

        $this->assertCount(8, $config->getEndPoints());
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\EndPoint', $config->getEndPoint('cancel_url'));
        $this->assertEquals('https://auth.ci.dru-id.com/oauth2/authorize/redirect', $config->getEndPoint('cancel_url')->getUrl());

        $this->assertCount(3, $config->getApis());
        $this->assertInstanceOf('\Genetsis\core\OAuth\Beans\OAuthConfig\Api', $config->getApi('api.activityid'));
        $this->assertEquals('/public/v1/bookmark/acknowledge', $config->getApi('api.activityid')->getEndpoint('click_newsletter'));

    }

    private function getXmlExample_v1_4()
    {
        return <<<'EOD'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<oauth-config country="es" environment="ci" generated-on="21/11/2016T12:23:56 +00:00" version="1.4">

    <credentials>
        <clientid>XXXXXXX</clientid>
        <clientsecret>YYYYYYY</clientsecret>
    </credentials>

    <hosts>
        <host id="my-host-1">//www.foo-host-1.com</host>
        <host id="my-host-2">//www.foo-host-2.com</host>
    </hosts>

    <data>
        <name>Beefeater In-Edit (test)</name>
        <brand key="beefeater">Beefeater</brand>
        <opi>SPIRIT-ID-REGLAS</opi>
    </data>

    <redirections>
        <url default="true" type="confirmUser">http://www.foo.com/actions</url>
        <url default="true" type="postChangeEmail">http://www.foo.com/actions</url>
        <url default="true" type="register">http://www.foo.com/actions</url>
        <url default="true" type="postLogin">http://www.foo.com/actions</url>
        <url default="true" type="postEditAccount">http://www.foo.com/actions</url>
    </redirections>

    <sections>
        <section default="true" id="1111111-main" opi="my-opi"/>
        <section id="2222222-main" opi="my-opi"/>
        <section id="3333333-main" opi="my-opi"/>
    </sections>

    <endpoints>
        <url id="authorization_endpoint">https://auth.ci.dru-id.com/oauth2/authorize</url>
        <url id="signup_endpoint">https://auth.ci.dru-id.com/oauth2/authorize</url>
        <url id="token_endpoint">http://auth.ci.dru-id.com/oauth2/token</url>
        <url id="next_url">https://auth.ci.dru-id.com/oauth2/authorize/redirect</url>
        <url id="cancel_url">https://auth.ci.dru-id.com/oauth2/authorize/redirect</url>
        <url id="logout_endpoint">https://auth.ci.dru-id.com/oauth2/revoke</url>
        <url id="edit_account_endpoint">https://register.ci.dru-id.com/register/edit_account_input</url>
        <url id="complete_account_endpoint">https://register.ci.dru-id.com/register/complete_account_input</url>
    </endpoints>

    <apis>
        <api base-url="https://www.opinator.com/opi" id="opi" name="opi" version="1">
            <url id="rules">/r</url>
        </api>
        <api base-url="http://api.ci.dru-id.com/api" id="api.user:v1" name="api.user" version="1">
            <url id="user">/user</url>
        </api>
        <api base-url="http://graph.ci.dru-id.com/activityid" id="api.activityid:v1" name="api.activityid" substitution-var="{objectType}" version="1">
            <url id="participate">/v1/game/request</url>
            <url id="reject_participation">/v1/game/reject</url>
            <url id="win_prize_content">/v1/product/win</url>
            <url id="share">/v1/{objectType}/share</url>
            <url id="click_newsletter">/public/v1/bookmark/acknowledge</url>
            <url id="opens_newsletter">/public/v1/article/open</url>
            <url id="fill_survey">/v1/question/complete</url>
            <url id="upload_ugc">/v1/{objectType}/create</url>
            <url id="delete_ugc">/v1/{objectType}/delete</url>
            <url id="negative_comment">/v1/comment/create</url>
            <url id="reject_ugc">/v1/{objectType}/reject</url>
            <url id="positive_comment">/v1/comment/create</url>
            <url id="neutral_comment">/v1/comment/create</url>
            <url id="report">/v1/{objectType}/flag-as-inappropriate</url>
            <url id="vote_ugc">/v1/review/create</url>
            <url id="edit_ugc">/v1/{objectType}/update</url>
            <url id="view_ugc">/v1/{objectType}/consume</url>
            <url id="retweet">/v1/note/share</url>
            <url id="follow">/v1/person/follow</url>
            <url id="like">/v1/{objectType}/like</url>
            <url id="unlike">/v1/{objectType}/unlike</url>
            <url id="vote_brand_content">/v1/{objectType}/review</url>
            <url id="view_brand_content">/v1/{objectType}/consume</url>
            <url id="acceptance">/v1/product/accept</url>
            <url id="event_attendance">/v1/event/attend</url>
            <url id="make_a_friend">/v1/person/make-friend</url>
            <url id="download_coupon"/>
            <url id="scan_coupon_in_pos"/>
            <url id="redeem_coupon_in_pos"/>
            <url id="check_in">/v1/place/checkin</url>
            <url id="win_prize_shopper"/>
            <url id="subscribe"/>
            <url id="neutral_post"/>
            <url id="negative_post"/>
            <url id="positive_post"/>
            <url id="buy_tccc_products"/>
            <url id="buy_coupon_with_euros"/>
            <url id="shopping_cart_generated"/>
            <url id="refer_to_a_friend"/>
            <url id="bring_a_friend"/>
            <url id="win_prize_promotion"/>
            <url id="enter_incorrect_pincode"/>
            <url id="redeem_pincode"/>
            <url id="redeem_points"/>
            <url id="change_pincodes"/>
            <url id="change_points"/>
            <url id="public_image">/public/v1/image</url>
        </api>
    </apis>

</oauth-config>
EOD;

    }

}
