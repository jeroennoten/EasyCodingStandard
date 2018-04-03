<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\Tests;

use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PHPUnit\Framework\TestCase;
use Symplify\EasyCodingStandard\Skipper;

final class SkipperRemoveUnusedTest extends TestCase
{
    /**
     * @var Skipper
     */
    private $skipper;

    protected function setUp(): void
    {
        $this->skipper = new Skipper($this->createSkipParameter(), []);
    }

    public function testKeepAll(): void
    {
        $this->assertSame([
            DeclareStrictTypesFixer::class => [
                0 => 'someFile',
                1 => '*/someDirectory/*',
            ],
            'someSniff.someCode' => null,
            'someSniff.someOtherCode' => [
                '*/someDirectory/*',
            ],
        ], $this->skipper->getUnusedSkipped());
    }

    public function testRemoveFile(): void
    {
        $this->skipper->removeFileFromUnused('someFile');

        $this->assertSame([
            DeclareStrictTypesFixer::class => [
                1 => '*/someDirectory/*',
            ],
            'someSniff.someCode' => null,
            'someSniff.someOtherCode' => [
                '*/someDirectory/*',
            ],
        ], $this->skipper->getUnusedSkipped());
    }

    /**
     * @return mixed[]
     */
    private function createSkipParameter(): array
    {
        return [
            DeclareStrictTypesFixer::class => [
                'someFile',
                '*/someDirectory/*',
            ],
            'someSniff.someCode' => null,
            'someSniff.someOtherCode' => [
                '*/someDirectory/*',
            ],
        ];
    }
}
