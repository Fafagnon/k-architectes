<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion Administration | K-ARCHITECTES</title>
<link rel="icon" href="{{ asset('assets/favicon.svg') }}" type="image/svg+xml">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<style>
  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: var(--calque);
    padding: 24px;
  }
  .login-box {
    width: 100%;
    max-width: 440px;
    background: var(--blanc);
    border: var(--trait);
    padding: clamp(32px, 6vw, 48px);
  }
</style>
</head>
<body>

<div class="login-box">
  <div style="margin-bottom: 32px; text-align: center;">
    <a href="{{ route('home') }}" style="display: inline-block; margin-bottom: 16px;">
      <img src="{{ asset('assets/img/logo-k.png') }}" alt="K-ARCHITECTES" style="height: 36px; width: auto;">
    </a>
    <h1 style="font-size: 1.5rem; letter-spacing: -.02em; margin-bottom: 8px;">Administration</h1>
    <p style="font-size: .875rem; color: var(--graphite); margin: 0;">Connectez-vous pour gérer les contenus du cabinet</p>
  </div>

  @if(session('info'))
    <div style="padding: 12px 16px; background: var(--beton); border: var(--trait); font-size: .875rem; margin-bottom: 20px;">
      {{ session('info') }}
    </div>
  @endif

  @if($errors->any())
    <div style="padding: 12px 16px; background: #ffebeb; border: 1px solid #d60000; color: #900000; font-size: .875rem; margin-bottom: 20px;">
      <ul style="margin: 0; padding-left: 16px;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.login.submit') }}" method="post" class="formulaire">
    @csrf

    <div class="champ @error('email') champ--erreur @enderror" style="margin-bottom: 20px;">
      <label for="email">Adresse e-mail</label>
      <input id="email" name="email" type="email" autocomplete="email" required autofocus value="{{ old('email') }}">
    </div>

    <div class="champ @error('password') champ--erreur @enderror" style="margin-bottom: 20px;">
      <label for="password">Mot de passe</label>
      <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; font-size: .875rem;">
      <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
        <input type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: var(--noir);">
        <span>Se souvenir de moi</span>
      </label>
    </div>

    <button type="submit" class="bouton" style="width: 100%;">Se connecter</button>
  </form>

  <div style="margin-top: 32px; padding-top: 20px; border-top: 1px solid var(--beton); text-align: center; font-size: .8125rem;">
    <a class="lien" href="{{ route('home') }}">← Revenir au site public</a>
  </div>
</div>

</body>
</html>
