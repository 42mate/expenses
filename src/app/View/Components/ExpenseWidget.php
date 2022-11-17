<?php

namespace App\View\Components;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ExpenseWidget extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'None')
    {
        $this->title = $title;
        $this->data = [];
        $this->createRoute = null;
        $this->indexRoute = null;

        if ($title == 'Expenses') {
            $this->data = Expense::getTotals();
            $this->createRoute = route('expense.create');
            $this->indexRoute = route('expense.index');
        }

        if ($title == 'Incomes') {
            $this->data = Income::getTotals();
            $this->createRoute = route('incomes.create');
            $this->indexRoute = route('incomes.index');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.expense-widget', [
            'data' => $this->data,
            'title' => $this->title,
            'create_route' => $this->createRoute,
            'index_route' => $this->indexRoute
        ]);
    }
}
