<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function getAllDashboard()
    {
        $timeline = History::where('type' , 0)->orderBy('id', 'DESC')->get();
        $historiesTable = History::all();
        $categories = Category::where('type' , 0)->get();

        $dataExpense = [];
        $dataIncome = [];
        $dataExpenseSum = [];
        $dataIncomeSum = [];
        $sumExpense = 0;
        $sumIncome = 0;



        for ($i = 1; $i <= 12; $i++) {
            $expense = 0;
            $income = 0;
            foreach ($historiesTable as $history) {
                $month = Carbon::parse($history->time_date)->format('m');
                if ($month == $i) {
                    if ($history->type == 0) {
                        $expense += $history->amount;
                        $sumExpense += $history->amount;
                    }
                    else{
                        $income += $history->amount;
                        $sumIncome += $history->amount;
                    }
                }
            }
            array_push($dataExpenseSum, $sumExpense);
            array_push($dataIncomeSum, $sumIncome);

            array_push($dataIncome, $income);
            array_push($dataExpense, $expense);
        }

        $sumCategorySet = [];
        $nameCategorySet = [];
        $colorSet = [];
        $color = [
            'rgba(255, 99, 132)',
            'rgba(54, 162, 235)',
            'rgba(255, 206, 86)',
            'rgba(75, 192, 192)',
            'rgba(153, 102, 255)',
        ];

        $sumCategory = 0;
        $nameCategory = "";
        $index = 0;
        foreach($categories as $category)
        {
            if($index > 4)
            {
                $index = 0;
            }
            $color[$index];
            $sumCategory = 0;
            $nameCategory = $category->name;
            foreach($category->histories as $history)
            {
                $sumCategory += $history->amount;
            }
            array_push($colorSet, $color[$index]);
            array_push($sumCategorySet, $sumCategory);
            array_push($nameCategorySet, $nameCategory);
            $index++;
        }

        $dataSet = [
            'timeline' => $timeline,
            'history' => $historiesTable,
            'expense' => $dataExpense,
            'income' => $dataIncome,
            'expenseSum' => $dataExpenseSum,
            'incomeSum' => $dataIncomeSum,
            'nameCatSet' => $nameCategorySet,
            'sumCatSet' => $sumCategorySet,
            'color' => $colorSet,
        ];
        return response()->json(['status' => true , 'dataSet' => $dataSet]);
    }
}
