@extends('layouts.head')

@section('content')

    <div class="container">
        <!-- slideToggle -->
        <section class="slide_parent">
            <div class="write_btn_div">
                <a class="waves-effect waves-light btn-floating write_btn"><i class="fas fa-pen"></i></a>
            </div>
            <div class="slide_content display_none">
                <a href="#!" class="slide_close waves-effect waves-green btn-flat"><i class="fas fa-times"></i></a>
                <h4 style="text-align: center">買い物登録</h4>
                @foreach ($users as $user)
                    {!! Form::open(['route' => 'expenses.store']) !!}
                        <div style="display: none">
                            {!! Form::label('ID') !!}
                            {!! Form::text('user_id', Auth::user()->id) !!}
                        </div>
                        <div>
                            {!! Form::label('カテゴリー') !!}
                            {!! Form::select('category',
                                ['食費'=>'食費',
                                 '日用品'=>'日用品',
                                 '保険・医療'=>'保険・医療',
                                 '固定費'=>'固定費',
                                 '衣類'=>'衣類',
                                 '小遣い'=>'小遣い',
                                 'レジャー'=>'レジャー',
                                 'その他'=>'その他',
                                ]) 
                            !!}
                        </div>
                        <div>
                            {!! Form::label('商品') !!}
                            {!! Form::text('name') !!}
                        </div>
                        <div>
                            {!! Form::label('金額') !!}
                            {!! Form::tel('money') !!}
                        </div>
                        <div>
                            @php
                                $today = date("Ymd");
                            @endphp
                            {!! Form::label('日付') !!}
                            {!! Form::tel('day', $today) !!}
                        </div>
                    <button type='submit' class='btn'>記入</button>
                    {!! Form::close() !!}
                    
                <?php break; ?>
                @endforeach

            </div><!--slide-content-->
        </section><!--slide_parent-->
        
        <?php
            $y = date('Y');
            $m = date('m');
            $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y)); // 1日の曜日を取得
            $d = 1;
            $today = date('d');
        ?>
        <h3>{{ $y }}年{{ $m }}月の家計簿</h3>
        <h3 class="past_exp_flex">支出合計 ¥{{ number_format($this_month_sum) }}</h3>
            
        <table>
            <?php
                $this_month_1st = date("Y/m/01");
                $this_month_last = date("Y/m/t");
                $this_month = date("Y-m-");
                $this_month_ja = date("Y年n月");
                $last_d = date('t');
                $d = 1;
            
                $expense_days = \App\Expense::where('user_id', \Auth::id())->whereBetween('day', [$this_month_1st, $this_month_last])->orderBy('day', 'desc')->get()->toArray();
                $array_expense_days = array_column($expense_days, 'day');
            ?> 
            @for($last_d; $last_d >= $d; $last_d--)
                @foreach($array_expense_days as $array_expense_day)
                    @if($this_month.sprintf('%02d',$last_d) == $array_expense_day)
                        <?php    
                            //年月日から曜日$week[$w]を算出
                            $datetime = new DateTime($this_month.sprintf('%02d',$last_d));
                            $week = array("日", "月", "火", "水", "木", "金", "土");
                            $w = (int)$datetime->format('w');
                        ?>   
                        <tr style="background-color: lightgrey;">
                            <th class="date" colspan="4">{{ $this_month_ja.$last_d }}日({{$week[$w]}})</th>
                        </tr>
                        <?php  
                            //その日の出費明細を配列にする
                            $calendar_expenses = \App\Expense::where('user_id', \Auth::id())->where('day', $this_month.sprintf('%02d',$last_d))->get()->toArray();
                            $categories = array_column($calendar_expenses, 'category' );
                            $names = array_column($calendar_expenses, 'name' );
                            $moneys = array_column($calendar_expenses, 'money' );
                            $ids = array_column($calendar_expenses, 'id' );
                            $i = 0;
                        ?>    
                        @foreach($categories as $category)
                            <tr>
                                <td style="width: 20%;">{{ $category }}</td><td>{{ $names[$i] }}</td><td style="text-align: right; width: 30%;">¥{{ number_format($moneys[$i]) }}</td>
                                {!! Form::open(['route' => ['expenses.destroy', $ids[0]], 'method' => 'delete']) !!}
                                    <td style="text-align: right; width: 12%;"><button type='submit' class='btn-flat' style="padding-left: 0;"><i class='far fa-trash-alt' style='font-size: 1.3em; color: grey'></i></button></td>
                                {!! Form::close() !!}
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        @break
                    @endif
                @endforeach
            @endfor
        </table>
        
        <hr class="make_bottom">
        <hr class="make_bottom">
    </div><!--.container-->
    
    <footer>
        <div class="footer_icons">
            <div>
                <a href="show_exp">
                    <div class="icon_to_center"><i class="fas fa-home icon"></i></div>
                    <div class="font">ホーム</div>
                </a>
            </div>
            <div class="selected">
                <div class="icon_to_center"><i class="fas fa-list-ul"></i></div> 
                <div class="font">家計簿</div>
            </div>
            <div>
                <a href="calendar">
                    <div class="icon_to_center"><i class="far fa-calendar-check"></i></div>
                    <div class="font">カレンダー</div>
                </a>
            </div>
            <div>
                <a href="accountLists">
                    <div class="icon_to_center"><i class="fas fa-shopping-cart"></i></div>
                    <div class="font">欲しい物</div>
                </a>
            </div>
            <div>
                <a href="edit">
                    <div class="icon_to_center"><i class="far fa-laugh"></i></div>
                    <div class="font">編集</div>
                </a>
            </div>
        </div>
    </footer>
    
    <script src="js/main.js"></script>

@endsection
