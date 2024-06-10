@extends('layouts.app')

@section('main')
<div class="main profile-edit__container">
  <h1 class="profile-edit__container__header header">プロフィール設定</h1>
  @include('components.session')
  <form action="{{ route('profile.update') }}" method="post" class="profile-edit__container--form form" enctype="multipart/form-data">
    @csrf
    <div class="profile-edit__container__img">
      <img id="profileImage" class="profile__image" src="{{ $user->icon_image ?? '' }}" alt="">
      <label for="icon_image" class="custom-file-label btn--border-pink">画像を選択する</label>
      <input id="icon_image" type="file" class="profile--edit custom-file-input" name="icon_image">
    </div>
    <div class="profile-edit__container--form__inner form__inner">
      <div class="form__inner-group">
        <p>ユーザー名</p>
        <div class="profile-edit__container--form-tag form-input--style">
          <input type="text" name="name" value="{{ $user->name }}" placeholder="">
        </div>
        <p class="error-message">@error('name'){{ $message }}@enderror</p>
      </div>
      <div class="form__inner-group">
        <p>郵便番号</p>
        <div class="profile-edit__container--form-tag form-input--style">
          <input type="text" name="postal_code" value="{{ $user->postal_code }}">
        </div>
        <p class="error-message">@error('postal_code'){{ $message }}@enderror</p>
      </div>
      <div class="form__inner-group">
        <p>住所</p>
        <div class="profile-edit__container--form-tag form-input--style">
          <input type="text" name="address" value="{{ $user->address }}">
        </div>
        <p class="error-message">@error('address'){{ $message }}@enderror</p>
      </div>
      <div class="form__inner-group">
        <p>建物</p>
        <div class="profile-edit__container--form-tag form-input--style">
          <input type="text" name="building_name" value="{{ $user->building_name }}">
        </div>
        <p class="error-message">@error('building_name'){{ $message }}@enderror</p>
      </div>
    </div>
    <button class="btn--bg-pink" type="submit">更新する</button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('icon_image');
    const fileLabel = document.querySelector('.custom-file-label');

    document.getElementById('icon_image').addEventListener('change', function(event) {
      const [file] = event.target.files;
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profileImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  });
</script>
@endsection