<?php

namespace helpers\iam\jwt;

use Yii;
use yii\base\Component;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Configuration as BaseConfiguration;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;

class Configuration extends Component
{
    public $secret = '';
    private $_config;

    public function init()
    {
        parent::init();
        $this->secret = $this->secret ?: (isset(Yii::$app->params['jwtSecret']) ? Yii::$app->params['jwtSecret'] : bin2hex(random_bytes(64)));

        $signer = new Sha256();
        $key = InMemory::plainText($this->secret);

        $this->_config = BaseConfiguration::forSymmetricSigner($signer, $key)
            ->withValidationConstraints(
                new SignedWith($signer, $key),
                new LooseValidAt(new SystemClock(new \DateTimeZone('UTC')))
            );
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function builder()
    {
        return $this->getConfig()->builder();
    }
    public function parser()
    {
        return $this->getConfig()->parser();
    }
    public function signer()
    {
        return $this->getConfig()->signer();
    }
    public function signingKey()
    {
        return $this->getConfig()->signingKey();
    }
    public function validationConstraints(): array
    {
        return $this->getConfig()->validationConstraints();
    }
}
