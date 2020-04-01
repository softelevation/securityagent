@extends('layouts.app')
@section('content')
<section id="top-banner" class="d-flex flex-column justify-content-center align-items-center">
  <div class="container">
    <h2>Rejoignez l’aventure <b>Be On Time</b>, pour développer votre activité <b>d’Agents de Sécurité</b>, partout en France.</h2>
  </div>
</section>

<section id="section1" class="section1">
  <div class="container">
    <div class="row">
      <div class="col-xl-5 col-lg-5">
        <img style="width: 100%;" class="img-thumbnail" src="{{asset('images/agent_img1.jpg')}}">
      </div>
      <div class="text_panel col-xl-7 col-lg-7">
        <p><b>Be On Time</b>, a développé un modèle unique et innovant au service des Agents de Sécurité. Nous sommes à la recherche de partenaires en quête de missions en sécurité privée : </p>
        <p>Nous permettons aux Agents qui s’inscrivent sur notre plateforme, (<a href="{{url('register-agent-view')}}" target="_blank">cliquez ici pour vous inscrire maintenant</a>) de préserver leur qualité de vie et obtenir plus, en exerçant sous le statut de salarié ou indépendant.</p>
        <p>À travers notre outil, nous souhaitons vous permettre de trouver de nouvelles missions près de chez vous et d’améliorer votre rémunération, même si vous avez déjà une activité.</p>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="heading text-center">
            <h2>Pour s’inscrire c’est très simple</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}">
        </div>
      </div>
      <div class="col-md-12 text-center">
        <div class="card">
          <div class="card-body text_panel text-left">
            <p class="card-text">1. Indiquez vos compétences, le type de missions que vous souhaitez, votre expérience, vos disponibilités, etc. Tout ce qui permettra de vous trouver facilement.</p>
            <p>2. Une fois inscrit•e, vous êtes référencé•e sur la plateforme et les clients peuvent vous solliciter pour des missions.</p>
            <p>3. Vous ne souhaitez plus être répertorié•e ? Masquez simplement votre profil si vous n’êtes plus disponible.</p>
          </div>
          <img src="{{asset('images/agent_img2.jpg')}}" class="card-img-top">
        </div>
      </div>
      <div class="col-md-12 text_panel mt-3">
        <p>Notre plateforme représente un réel levier de croissance, flexible, fiable et économique de votre activité sans aucun investissement humain et matériel. Nous sollicitons vos services pour effectuer des prestations de sécurisation pour nos clients.<p>
        <p>Avec + de 20 ans d’expérience dans le domaine de la sécurité, notre style de gestion est basée surl’accessibilité et permet d’offrir à tous nos partenaires agents des possibilités de développement.</p>
      </div>
    </div>
  </div>
</section>
  
@endsection