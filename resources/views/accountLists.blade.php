@extends('layouts.head')

@section('content')
<body>
    <div class="container">
        @foreach ($users as $user)
            <!-- slideToggle -->
            <section class="slide_parent">
                <!--トグル呼び出しボタン-->
                <div class="write_btn_div">
                    <a class="waves-effect waves-light btn-floating write_btn" href="#"><i class="fas fa-pen"></i></a>
                </div>
                <!--slideToggle contents-->
                <div class="slide_content display_none">
                    <a href="#!" class="slide_close waves-effect waves-green btn-flat"><i class="fas fa-times"></i></a>
                    <h4 style="text-align: center">欲しい物を登録してください</h4>
                    @foreach ($users as $user)
                        {!! Form::open(['route' => 'accountLists.store']) !!}
                            <div style="display: none">
                                {!! Form::label('ID') !!}
                                {!! Form::text('user_id', Auth::user()->id) !!}
                            </div>
                            <div>
                                {!! Form::label('名前') !!}
                                {!! Form::text('name') !!}
                            </div>
                            <div>
                                {!! Form::label('メモ') !!}
                                {!! Form::text('memo') !!}
                            </div>
                            <div style="display: none">
                                {!! Form::label('switch') !!}
                                {!! Form::text('switch', 0) !!}
                            </div>
                            <button type="submit" class="btn">記入</button>
                        {!! Form::close() !!}
                    <?php break; ?>
                    @endforeach
                </div><!--slide-content-->
            </section><!--slide_parent-->
            
            <h2>欲しい物リスト</h2>
            @foreach ($accountLists as $accountList)
                <table class="listTable">
                    <tr class="date">
                        <th class="date" colspan="4" style="background-color: lightgrey;">
                            {{ $accountList->created_at }}
                        </th>
                    </tr>
                    @if($accountList->switch == 0)
                    <tr>    
                        <td>
                            <div>
                                {!! Form::open(['route' => ['accountLists.edit', $accountList->id], 'method' => 'post']) !!}
                                    <div style="display: none;">
                                        {!! Form::text('switch', 1) !!}
                                    </div>
                                    <button type="submit" class="btn-small red"></button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                        <td>
                            <div class="name">
                               {{ $accountList->name }}
                            </div>
                        </td>
                        <td>
                            <div class="deleteButton">
                                {!! Form::open(['route' => ['accountLists.destroy', $accountList->id], 'method' => 'delete']) !!}
                                    <button type="submit" class="btn-flat"><i class="far fa-trash-alt" style="font-size: 1.2em; color: grey"></i></button>
                                {!! Form::close() !!}
                            </div>
                              
                        </td> 
                    </tr>   
                    @else
                    <tr>    
                        <td>
                            <div>
                                {!! Form::open(['route' => ['accountLists.edit', $accountList->id], 'method' => 'post']) !!}
                                    <div style="display: none;">
                                        {!! Form::text('switch', 0) !!}
                                    </div>
                                    <button type="submit" class="btn-small white"></button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                        <td>
                            <div class="lined_name">
                                {{ $accountList->name }}
                            </div>
                        </td>
                        <td>
                            <div class="deleteButton">
                                {!! Form::open(['route' => ['accountLists.destroy', $accountList->id], 'method' => 'delete']) !!}
                                    <button type="submit" class="btn-flat"><i class="far fa-trash-alt" style="font-size: 1.2em; color: grey"></i></button>
                                {!! Form::close() !!}
                            </div>
                             
                        </td>
                    </tr>        
                    @endif
                    <tr>
                        @if($accountList->memo == !null)
                            <td colspan="4">メモ：{{ $accountList->memo }}</td>
                        @endif
                    </tr>
                </table>
            @endforeach

        <?php break; ?>
        @endforeach
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
            <div>
                <a href="past_exp">
                    <div class="icon_to_center"><i class="fas fa-list-ul"></i></div> 
                    <div class="font">家計簿</div>
                </a>
            </div>
            <div>
                <a href="calendar">
                    <div class="icon_to_center"><i class="far fa-calendar-check"></i></div>
                    <div class="font">カレンダー</div>
                </a>
            </div>
            <div class="selected">
                <div class="icon_to_center"><i class="fas fa-shopping-cart"></i></div>
                <div class="font">欲しい物</div>
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
</body> 
@endsection
