<?php

namespace ZFTest\OAuth2\Doctrine\ORM;

use OAuth2\Scope;
use OAuth2\Storage\ScopeInterface;

class ScopeTest extends AbstractTest
{
    /** @dataProvider provideStorage */
    public function testScopeExists($storage)
    {
        if ($storage instanceof NullStorage) {
            $this->markTestSkipped('Skipped Storage: ' . $storage->getMessage());

            return;
        }

        if (!$storage instanceof ScopeInterface) {
            // incompatible storage
            return;
        }

        //Test getting scopes
        $scopeUtil = new Scope($storage);
        $this->assertTrue($scopeUtil->scopeExists('supportedscope1'));
        $this->assertTrue($scopeUtil->scopeExists('supportedscope1 supportedscope2 supportedscope3'));
        $this->assertFalse($scopeUtil->scopeExists('fakescope'));
        $this->assertFalse($scopeUtil->scopeExists('supportedscope1 supportedscope2 supportedscope3 fakescope'));

        $this->assertTrue($storage->scopeExists('event_stop_propagation'));
    }

    /** @dataProvider provideStorage */
    public function testGetDefaultScope($storage)
    {
        if ($storage instanceof NullStorage) {
            $this->markTestSkipped('Skipped Storage: ' . $storage->getMessage());

            return;
        }

        if (!$storage instanceof ScopeInterface) {
            // incompatible storage
            return;
        }

        // test getting default scope
        $scopeUtil = new Scope($storage);
        $expected = explode(' ', $scopeUtil->getDefaultScope());
        $actual = explode(' ', 'defaultscope1 defaultscope2');
        sort($expected);
        sort($actual);
        $this->assertEquals($expected, $actual);

        $this->assertTrue($storage->getDefaultScope('event_stop_propagation'));
    }
}
