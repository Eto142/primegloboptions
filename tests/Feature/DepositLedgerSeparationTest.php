<?php

namespace Tests\Feature;

use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Grammars\SQLiteGrammar;
use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Database\SQLiteConnection;
use Tests\TestCase;

class DepositLedgerSeparationTest extends TestCase
{
    private $originalResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalResolver = Model::getConnectionResolver();
        $connection = new SQLiteConnection(null, '', '', []);
        $connection->setQueryGrammar(new SQLiteGrammar($connection));
        $connection->setPostProcessor(new Processor());

        $resolver = new ConnectionResolver(['test' => $connection]);
        $resolver->setDefaultConnection('test');
        Model::setConnectionResolver($resolver);
    }

    protected function tearDown(): void
    {
        Model::setConnectionResolver($this->originalResolver);

        parent::tearDown();
    }

    public function test_investment_deposits_are_separated_from_bank_queries(): void
    {
        $bankDeposits = (new Deposit())->newQuery()->bankSide();
        $investmentDeposits = (new Deposit())->newQuery()->investmentSide();
        $bankTransactions = (new Transaction())->newQuery()->bankSide();

        $this->assertStringContainsString('("deposit_type" is null or "deposit_type" != ?)', $bankDeposits->toSql());
        $this->assertSame(['investment'], $bankDeposits->getBindings());
        $this->assertStringContainsString('"deposit_type" = ?', $investmentDeposits->toSql());
        $this->assertSame(['investment'], $investmentDeposits->getBindings());
        $this->assertStringContainsString('("transaction" is null or "transaction" != ?)', $bankTransactions->toSql());
        $this->assertSame(['Investment Deposit'], $bankTransactions->getBindings());
    }
}
