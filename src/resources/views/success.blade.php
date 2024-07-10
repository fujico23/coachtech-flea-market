<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>flea-market</title>
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>

<body>
  <div class="main verification__container">
    <h1 class="verification__container__header header">お支払いが完了しました!</h1>
    <div class="verification__container__inner">
      <p>{{ __('マイページにてご確認下さい') }}</p>
      <div class="verification__container__btn-group">
        <a class="btn--border-pink--small" href="{{ route('mypage') }}">マイページへ</a>
      </div>
    </div>
  </div>

  <script>
    const mainContainer = document.createElement('div');
    mainContainer.classList.add('main', 'verification__container');

    const header = document.createElement('h1');
    header.classList.add('verification__container__header', 'header');
    header.textContent = 'お支払いが完了しました!';
    mainContainer.appendChild(header);

    const innerContainer = document.createElement('div');
    innerContainer.classList.add('verification__container__inner');
    mainContainer.appendChild(innerContainer);

    const paragraph = document.createElement('p');
    paragraph.textContent = 'マイページにてご確認下さい';
    innerContainer.appendChild(paragraph);

    const btnGroup = document.createElement('div');
    btnGroup.classList.add('verification__container__btn-group');
    innerContainer.appendChild(btnGroup);

    // Create link button
    const linkButton = document.createElement('a');
    linkButton.classList.add('btn--border-pink--small');
    linkButton.href = '/mypage';
    linkButton.textContent = 'マイページへ';
    btnGroup.appendChild(linkButton);

    document.body.appendChild(mainContainer);
  </script>
</body>


</html>