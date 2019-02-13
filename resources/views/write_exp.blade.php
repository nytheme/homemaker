@extends('layouts.head')

@section('content')

    <div class="container">
        @foreach ($users as $user)
            <h2>{{ Auth::user()->name }} 買い物登録</h2>
            
            <h2>買った物を登録してください</h2>
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
                    {!! Form::text('day', $today) !!}
                </div>
            {!! Form::submit('登録') !!}
            {!! Form::close() !!}
            
            <?php break; ?>
        @endforeach
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
            <div class="selected">
                <div class="icon_to_center"><i class="fas fa-pen"></i></div>
                <div class="font">記入</div>
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
