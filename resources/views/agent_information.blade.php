@extends('layouts.app')
@section('content')

<section id="top-banner" class="d-flex flex-column justify-content-center align-items-center">
  <div class="container">
    <!-- <h2>{!!__('frontend.text_55')!!}</h2> -->
    @if(app()->getLocale() == 'fr')
		<h2 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-weight: 500; line-height: 1.2; font-size: 2rem; color: #212529; font-family: SignikaRegular;">Rejoignez l&rsquo;aventure&nbsp;<span style="box-sizing: border-box; margin: 0px; padding: 0px; font-weight: bolder;">Be On Time</span>, pour d&eacute;velopper votre activit&eacute;&nbsp;<span style="box-sizing: border-box; margin: 0px; padding: 0px; font-weight: bolder;">d&rsquo;Agents de S&eacute;curit&eacute;</span>, partout en France.</h2>
	@else
		<h2 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-weight: 500; line-height: 1.2; font-size: 2rem; color: #212529; font-family: SignikaRegular;">Join the&nbsp;<span style="box-sizing: border-box; margin: 0px; padding: 0px; font-weight: bolder;">Be On Time&nbsp;</span>adventure, to develop your activity as&nbsp;<span style="box-sizing: border-box; margin: 0px; padding: 0px; font-weight: bolder;">Security Officers&nbsp;</span>, everywhere in France.</h2>
	@endif
  </div>
</section>

<section id="section1" class="section1">
  <div class="container">
    <div class="row">
      <div class="col-xl-5 col-lg-5">
        <img style="width: 100%;" class="img-thumbnail" src="{{asset('images/agent_img1.jpg')}}">
      </div>
      <div class="text_panel col-xl-7 col-lg-7">
		@if(app()->getLocale() == 'fr')
			<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;"><span style="box-sizing: border-box; margin: 0px; padding: 0px; font-weight: bolder;">Be On Time</span>, a d&eacute;velopp&eacute; un mod&egrave;le unique et innovant au service des Agents de S&eacute;curit&eacute;. Nous sommes &agrave; la recherche de partenaires en qu&ecirc;te de missions en s&eacute;curit&eacute; priv&eacute;e :</p>
			<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">Nous permettons aux Agents qui s&rsquo;inscrivent sur notre plateforme, (<a style="box-sizing: border-box; margin: 0px; padding: 0px; color: #ffc107; text-decoration-line: none; background-color: transparent;" href="{{ url('register-agent-view') }}" target="_blank" rel="noopener">cliquez ici pour vous inscrire maintenant</a>) de pr&eacute;server leur qualit&eacute; de vie et obtenir plus, en exer&ccedil;ant sous le statut de salari&eacute; ou ind&eacute;pendant.</p>
			<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">&Agrave; travers notre outil, nous souhaitons vous permettre de trouver de nouvelles missions pr&egrave;s de chez vous et d&rsquo;am&eacute;liorer votre r&eacute;mun&eacute;ration, m&ecirc;me si vous avez d&eacute;j&agrave; une activit&eacute;.</p>
		@else
			<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;"><span style="box-sizing: border-box; margin: 0px; padding: 0px; font-weight: bolder;">Be On Time&nbsp;</span>, has developed a unique and innovative model for Security Agents. We are looking for partners looking for private security missions:</p>
			<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">We allow Agents who register on our platform, (<a style="box-sizing: border-box; margin: 0px; padding: 0px; color: #ffc107; text-decoration-line: none; background-color: transparent;" href="{{ url('register-agent-view') }}" target="_blank" rel="noopener">&nbsp;click here to register now&nbsp;</a>) to preserve their quality of life and get more , exercising under the status of employee or self-employed.</p>
			<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">Through our tool, we want to allow you to find new missions near you and improve your remuneration, even if you already have an activity.</p>
		@endif
      </div>
    </div>
  </div>
</section> 

<section>
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <div class="heading text-center">
            <h2>{!!__('frontend.text_57')!!}</h2>           
            <img src="{{asset('assets/images/heading_bottom.png')}}">
        </div>
      </div>
      <div class="col-md-12 text-center">
        <div class="card">
          <div class="card-body text_panel text-left">
            <!-- {!!__('frontend.text_58')!!} -->
			@if(app()->getLocale() == 'fr')
				<p class="card-text" style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">1. Indiquez vos comp&eacute;tences, le type de missions que vous souhaitez, votre exp&eacute;rience, vos disponibilit&eacute;s, etc. Tout ce qui permettra de vous trouver facilement.</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">2. Une fois inscrit&bull;e, vous &ecirc;tes r&eacute;f&eacute;renc&eacute;&bull;e sur la plateforme et les clients peuvent vous solliciter pour des missions.</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">3. Vous ne souhaitez plus &ecirc;tre r&eacute;pertori&eacute;&bull;e ? Masquez simplement votre profil si vous n&rsquo;&ecirc;tes plus disponible.</p>
			@else
				<p class="card-text" style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">1. Indicate your skills, the type of missions you want, your experience, your availability, etc. Everything that will make it easy to find you.</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">2. Once registered, you are referenced on the platform and clients can request you for assignments.</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">3. You no longer wish to be listed? Just hide your profile if you&rsquo;re no longer available.</p>
			@endif
          </div>
          <img src="{{asset('images/agent_img2.jpg')}}" class="card-img-top">
        </div>
      </div>
      <div class="col-md-12 text_panel mt-3">
        <!-- {!!__('frontend.text_59')!!} -->
			@if(app()->getLocale() == 'fr')
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">Notre plateforme repr&eacute;sente un r&eacute;el levier de croissance, flexible, fiable et &eacute;conomique de votre activit&eacute; sans aucun investissement humain et mat&eacute;riel. Nous sollicitons vos services pour effectuer des prestations de s&eacute;curisation pour nos clients.</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">&nbsp;</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">Avec + de 20 ans d&rsquo;exp&eacute;rience dans le domaine de la s&eacute;curit&eacute;, notre style de gestion est bas&eacute;e surl&rsquo;accessibilit&eacute; et permet d&rsquo;offrir &agrave; tous nos partenaires agents des possibilit&eacute;s de d&eacute;veloppement.</p>
			@else
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">Our platform represents a real lever of growth, flexible, reliable and economic of your activity without any human and material investment. We solicit your services to provide security services for our customers.</p>
				<p style="box-sizing: border-box; margin: 0px 0px 1rem; padding: 0px; font-size: 18px; font-family: SignikaRegular;">With more than 20 years of experience in the security field, our management style is based on accessibility and allows us to offer development opportunities to all our agent partners.</p>
			@endif
      </div>
    </div> 
  </div>
</section>
  
@endsection
