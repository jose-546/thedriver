@extends('layouts.app')

@section('content')
<section id="section-settings" class="bg-gray-100">
    <div class="container">
        <div class="row">

            {{-- Sidebar --}}
             <div class="col-lg-3 mb30">
                            <div class="card p-4 rounded-5">
                                <div class="profile_avatar">
                                    <div class="profile_img">
                                        <img src="{{ asset('images/profile/1.jpg') }}" alt="">
                                    </div>
                                    <div class="profile_name">
                                        <h4>
                                            {{ auth()->user()->username }}                                                  
                                            <span class="profile_username text-gray">{{ auth()->user()->email }}</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">
                                    <li>
                                        <a href="{{ route('dashboard') }}" 
                                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                        <i class="fa fa-home"></i> Tableau de bord
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('profile.edit') }}" 
                                        class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                        <i class="fa fa-user"></i> Mon Profil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reservations.index') }}" 
                                        class="{{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                                        <i class="fa fa-calendar"></i> Mes Réservations
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('cars.search') }}" 
                                        class="{{ request()->routeIs('cars.search') ? 'active' : '' }}">
                                        <i class="fa fa-car"></i> Voitures Disponibles
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}" 
                                        onclick="event.preventDefault(); this.nextElementSibling.submit();">
                                            <i class="fa fa-sign-out"></i> Déconnexion
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>

                                </ul>

                            </div>

                            
                        </div>

            {{-- Main Content --}}
            <div class="col-lg-9">
                <div class="card p-4 rounded-5">

                    {{-- Onglets --}}
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab">Informations personnelles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">Modifier Mot de passe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="delete-tab" data-bs-toggle="tab" href="#delete" role="tab">Supprimer le compte</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="profileTabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            @include('profile.partials.update-profile-information-form') {{-- ici tu mets tes inputs Bootstrap --}}
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            @include('profile.partials.update-password-form')
                        </div>
                        <div class="tab-pane fade" id="delete" role="tabpanel">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
