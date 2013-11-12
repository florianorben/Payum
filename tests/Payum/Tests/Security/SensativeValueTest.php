<?php
namespace Payum\Tests\Security;

use Payum\Security\SensitiveValue;

class SensitiveValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeFinal()
    {
        $rc = new \ReflectionClass('Payum\Security\SensitiveValue');

        $this->assertTrue($rc->isFinal());
    }

    /**
     * @test
     */
    public function shouldImplementSerializableInterface()
    {
        $rc = new \ReflectionClass('Payum\Security\SensitiveValue');

        $this->assertTrue($rc->implementsInterface('Serializable'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithValue()
    {
        new SensitiveValue('cardNumber');
    }

    /**
     * @test
     */
    public function shouldAllowGetValueSetInConstructor()
    {
        $expectedValue = 'cardNumber';

        $sensitiveValue = new SensitiveValue($expectedValue);

        $this->assertEquals($expectedValue, $sensitiveValue->get());
    }

    /**
     * @test
     */
    public function shouldAllowEraseValue()
    {
        $expectedValue = 'cardNumber';

        $sensitiveValue = new SensitiveValue($expectedValue);

        //guard
        $this->assertEquals($expectedValue, $sensitiveValue->get());

        $sensitiveValue->erase();

        $this->assertNull($sensitiveValue->get());
        $this->assertAttributeEquals(null, 'value', $sensitiveValue);
    }

    /**
     * @test
     */
    public function shouldNotSerializeValue()
    {
        $sensitiveValue = new SensitiveValue('cardNumber');

        $serializedValue = serialize($sensitiveValue);

        $this->assertEquals('N;', $serializedValue);
        $this->assertNull(unserialize($serializedValue));
    }

    /**
     * @test
     */
    public function shouldReturnEmptyStringOnToString()
    {
        $sensitiveValue = new SensitiveValue('cardNumber');

        $this->assertEquals('', (string) $sensitiveValue);
    }
}
