<?php declare(strict_types=1);

namespace TDD\Test;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use TDD\ItemsTable;
use function PHPUnit\Framework\assertIsArray;

class ItemsTableTest extends TestCase
{
    /**
     * @var PDO
     */
    private $PDO;
    /**
     * @var ItemsTable
     */
    private $itemsTable;

    private function getConnection(): PDO
    {
        return new PDO('sqlite::memory:');
    }

    private function createTable(): void
    {
        $query = "
		CREATE TABLE `items` (
			`id`	INTEGER,
			`name`	TEXT,
			`price`	REAL,
			PRIMARY KEY(`id`)
		);
		";
        $this->PDO->exec($query);
    }

    private function populateTable(): void
    {
        $query = "
		INSERT INTO `items` VALUES (1,'Candy',1.00);
		INSERT INTO `items` VALUES (2,'TShirt',5.34);
		";
        $this->PDO->exec($query);
    }

    protected function setUp(): void
    {
        $this->PDO = $this->getConnection();
        $this->createTable();
        $this->populateTable();

        $this->itemsTable = new ItemsTable($this->PDO);
    }

    protected function tearDown(): void
    {
        unset($this->itemsTable, $this->PDO);
    }

    public function testFindForId(): void
    {
        $id = 1;
        $result = $this->itemsTable->findForId($id);

        assertIsArray(
            $result,
            'The result should always be an array.'
        );
        $this->assertEquals(
            $id,
            $result['id'],
            'The id key/value of the result for id should be equal to the id.'
        );
        $this->assertEquals(
            'Candy',
            $result['name'],
            'The id key/value of the result for name should be equal to `Candy`.'
        );
    }

    public function testFindForIdMock(): void
    {
        $id = 1;

        $PDOStatement = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['execute', 'fetch'])
            ->getMock();

        $PDOStatement->expects($this->once())
            ->method('execute')
            ->with([$id])
            ->will($this->returnSelf());
        $PDOStatement->expects($this->once())
            ->method('fetch')
            ->with($this->anything())
            ->willReturn('canary');

        $PDO = $this->getMockBuilder(PDO::class)
            ->setMethods(['prepare'])
            ->disableOriginalConstructor()
            ->getMock();

        $PDO->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM'))
            ->willReturn($PDOStatement);

        $ItemsTable = new ItemsTable($PDO);

        $output = $ItemsTable->findForId($id);

        $this->assertEquals(
            'canary',
            $output,
            'The output for the mocked instance of the PDO and PDOStatment should produce the string `canary`.'
        );
    }
}
