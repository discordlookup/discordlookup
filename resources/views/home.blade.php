@extends('layouts.app')

@section('title', __('Home'))
@section('description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
@section('keywords', '')
@section('robots', 'index, follow')

@section('content')

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="display-1 fw-bold text-primary">DiscordLookup</h1>
                <p class="lead fw-bold text-white">Get more out of Discord with Discord Lookup</p>
            </div>
        </div>
    </section>

    <div class="container">
        <a href="{{ route('snowflake') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="far fa-snowflake ms-auto me-auto" style="font-size: 2rem;"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">Snowflake</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">Get the creation date of a Snoflake, and detailed information about Discord users and guilds.</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('guildlist') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fab fa-discord ms-auto me-auto" style="font-size: 2rem;"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">Guild List</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">Show all the guilds you are on, with counters, permissions, features and more information about the guilds.</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('inviteinfo') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-link ms-auto me-auto" style="font-size: 2rem;"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">Invite Info</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">Get detailed information about every invite and vanity url.</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('snowflake-distance-calculator') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrows-alt-h ms-auto me-auto" style="font-size: 2rem;"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">Snowflake Distance Calculator</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">Calculate the distance between two Discord Snowflakes.</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('guild-shard-calculator') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-server ms-auto me-auto" style="font-size: 2rem;"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">Guild Shard Calculator</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">Calculate the Shard ID of a guild using the Guild ID and the total number of shards.</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

@endsection
