@extends('layouts.head')

@section('content')

    <div class="container">
        <?php
            // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
            if (isset($_GET['ym'])) {
                $ym = $_GET['ym'];
            } else {
                // 今月の年月を表示
                $ym = date('Y-m');
            }
            // タイムスタンプを作成し、フォーマットをチェックする
            $timestamp = strtotime($ym . '-01');
            if ($timestamp === false) {
                $ym = date('Y-m');
                $timestamp = strtotime($ym . '-01');
            }
            // カレンダーのタイトルを作成　例）2017年7月
            $html_title = date('Y年n月', $timestamp);
            // 前月・次月の年月を取得
            // 方法１：mktimeを使う mktime(hour,minute,second,month,day,year)
            $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
            $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
        ?>
        <div class="schedule_money">
            <!--<p><i class="far fa-calendar schedule_select selected"></i></p>-->
            <h4 class='calendar'><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h4>
            <!--<p><i class="fas fa-yen-sign money_select"></i></p>-->
        </div>
        
        <table class="money_calendar"><!--出費カレンダーここから display_none-->
            <tr>
                <th class='calendar'>月</th><th class='calendar'>火</th><th class='calendar'>水</th><th class='calendar'>木</th><th class='calendar'>金</th><th class='calendar'>土</th><th class='calendar'>日</th>
            </tr>
            <tr class='calendar'>
                @foreach ($expenses as $expense)
                    <?php
                        $y = substr($ym, 0, 4);//date('Y');
                        $m = substr($ym, 5, 2);//date('m');
                        $d = 1;
                        $today = date('Y-m-j');
                     
                        // 1日の曜日の前に空白を表示
                        $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
                    ?>
                    @for ($i = 2; $i <= $wd1; $i++) 
                        <td></td>
                    @endfor
                    
                    <!--カレンダー作成-->
                    @while (checkdate($m, $d, $y))
                        <?php
                            $date = $ym . '-' . $d;
                            $day = sprintf('%02d', $d);//1桁の数字を二桁表示
                            $day_for_expression = $y.'-'.$m.'-'.$day;//検索用の当日日付表示
                            //DBから該当データを呼び出すSQL文
                            //$calendar_expenses = \App\Expense::where('user_id', \Auth::id())->where('day', $day_for_expression)->get()->toArray();
                            //$calendar_expense = array_column( $calendar_expenses, 'money' );
                            $this_day_sum = \App\Expense::where('user_id', \Auth::id())->where('day', $day_for_expression)->sum('money');
                        ?>   
                        @if($this_day_sum != null)
                            @if($today == $date)
                                <td class='calendar'>
                                    <p class='today calendar'>{{ $d }}</p>
                                    <?php   
                                        //$spending = number_format($calendar_expense[0]);
                                        $thisDaySum = number_format($this_day_sum);
                                    ?>
                                    <a href='#' class='spending'>¥{{ mb_strimwidth( $thisDaySum,  0, 8, "....") }}</a>
                                </td>
                            @else
                                <td class='calendar'>
                                    <p class='calendar'>{{ $d }}</p>
                                    <?php
                                        $thisDaySum = number_format($this_day_sum);
                                    ?>
                                    <a href='#' class='spending'>¥{{ mb_strimwidth( $thisDaySum, 0, 8,"....") }}</a>
                                </td>     
                            @endif
                        @else 
                            @if($today == $date)
                                <td class='calendar'>
                                    <p class='today calendar'>{{ $d }}</p>
                                    -
                                </td>
                            @else 
                                <td class='calendar'>
                                    <p class='calendar'>{{ $d }}</p>
                                    -
                                </td>
                            @endif
                        @endif
                        @if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 0)  <!--0は日曜。W=日曜なら週を終了-->
                            </tr><!--列を閉じる-->
                            
                            <!-- 次の週がある場合は新たな行を準備-->
                            @if (checkdate($m, $d + 1, $y)) <!--週終了日に一日プラスした日から新しい列をスタート→whileへ-->
                                <tr class='calendar'>
                            @endif
                        @endif
                        
                        <?php $d++; ?>
                    @endwhile
                    <?php break; ?>
                @endforeach<!--($expenses as $expense)-->
            </tr>
        </table><!--出費カレンダーここまで-->
        
        <!--<table class="schedule_calendar"><!--スケジュールカレンダーここから-->
            <!--<tr>
                <th class='calendar'>月</th><th class='calendar'>火</th><th class='calendar'>水</th><th class='calendar'>木</th><th class='calendar'>金</th><th class='calendar'>土</th><th class='calendar'>日</th>
            </tr>
            <tr class='calendar'>
                @foreach ($expenses as $expense)
                    <?php
                        $y = substr($ym, 0, 4);//date('Y');
                        $m = substr($ym, 5, 2);//date('m');
                        $d = 1;
                        $today = date('Y-m-j');
                        // 1日の曜日の前に空白を表示
                        $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
                    ?>
                    @for ($i = 2; $i <= $wd1; $i++) 
                        <td></td>
                    @endfor
                    @while (checkdate($m, $d, $y))
                        <?php
                            $date = $ym . '-' . $d;
                            $day = sprintf('%02d', $d);//1桁の数字を二桁表示
                            $day_for_expression = $y.'-'.$m.'-'.$day;//検索用の当日日付表示
                            $this_day_sum = \App\Expense::where('user_id', \Auth::id())->where('day', $day_for_expression)->sum('money');
                        ?>    
                        @if($this_day_sum != null)
                            @if($today == $date)
                                <td class='calendar'>
                                    <p class='today calendar'>{{ $d }}</p>
                                    <a href='#' class='spending'>予定</a>
                                    
                                </td>
                             @else 
                                <td class='calendar'>
                                    <p class='calendar'>{{ $d }}</p>
                                    <a href='#' class='spending'>予定</a>
                                    
                                </td>
                            @endif
                         @else
                            @if($today == $date)
                                <td class='calendar'>
                                    <p class='today calendar'>{{ $d }}</p>
                                    
                                </td>
                             @else 
                                <td class='calendar'>
                                    <p class='calendar'>{{ $d }}</p>
                                    
                                </td>
                            @endif
                        @endif
                        @if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 0)  <!--0は日曜。W=日曜なら週を終了-->
                            <!--</tr>
                            @if (checkdate($m, $d + 1, $y)) <!--週終了日に一日プラスした日から新しい列をスタート→whileへ-->
                                <tr class='calendar'>
                            <!--@endif
                        @endif
                        
                        <?php $d++; ?>
                    @endwhile
                    <?php break; ?>
                @endforeach<!--($expenses as $expense)-->
            <!--</tr>
        </table><!--カレンダーここまで-->
        
        <!--<div class="write_btn_div">
            <a class="waves-effect waves-light btn-floating modal-trigger write_btn" href="#modal1"><i class="fas fa-pen"></i></a>
        </div>-->
        
        <hr class="make_bottom">
        <hr class="make_bottom">
    </div><!--.container-->
        
    <footer>
        <div class="footer_icons">
            <a href="show_exp">
                <div class="icon_to_center"><i class="fas fa-home icon"></i></div>
                <div class="font">ホーム</div>
            </a>
            <div>
                <a href="past_exp">
                    <div class="icon_to_center"><i class="fas fa-list-ul"></i></div> 
                    <div class="font">家計簿</div>
                </a>
            </div>
            <div>
                <div class="selected">
                    <div class="icon_to_center"><i class="far fa-calendar-check"></i></div>
                    <div class="font">カレンダー</div>
                </div>
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
