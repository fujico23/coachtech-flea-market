@extends('layouts.app')

@section('main')
<div class="main">
  <div class="link border-bottom-gray">
    <div class="link__inner">
      <a href="{{ route('index') }}" style="color: #ff5555;">おすすめ</a>
      <a href="{{ route('favorite.index') }}">マイリスト</a>
    </div>
  </div>
  <div class="item__container">
    @foreach($items as $item)
    <a class="item__container__card img-gray" href="{{ route('detail', $item) }}">
      @if($item->itemImages->isNotEmpty())
      <img src="{{ $item->itemImages->first()->image_url }}" alt="" width="100%" height="100%">
      @else
      <img src="" alt="" width="100%" height="100%">
      @endif
    </a>
    @endforeach
  </div>
</div>

<!-- メールアドレス検証状態管理用 -->
<div id="app-data" @if(Auth::check()) data-email-verified="{{ Auth::user()->hasVerifiedEmail() ? 'true' : 'false' }}" @endif style="display: none;"></div>

<!-- オーバーレイ -->
<div id="modalOverlay"></div>

<!-- モーダルウィンドウ本体 -->
<div id="emailVerifyModal" class="modal">
  <div class="mail-verify__modal__content">
    <p class="modal__content__close-button">&times;</p>
    <div class="modal__content_text-group">
      <p class="modal__content__text">メール認証が未実施です。</p>
      <p class="modal__content__text">登録したメールアドレスのボックスを確認して下さい。</p>
      <a href="{{ route('verification.notice') }}" class="modal__content__link btn--bg-pink">メール認証へ</a>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var appData = document.getElementById('app-data');

    // data-email-verified 属性の存在チェック
    if (appData.hasAttribute('data-email-verified')) {
      var emailVerified = appData.dataset.emailVerified === 'true';

      // メールアドレスが認証されていない場合にのみモーダル表示
      if (!emailVerified) {
        var modal = document.getElementById('emailVerifyModal');
        modal.style.display = "block";

        // 閉じるボタンの処理
        var closeButton = document.querySelector('.modal__content__close-button');
        closeButton.onclick = function() {
          modal.style.display = "none";
        }

        // モーダル外のエリアをクリックで閉じる処理
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
      }
    }
  });
</script>
@endsection