@section('title', __('Home'))
@section('description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
@section('keywords', '')
@section('robots', 'index, follow')

<div>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="display-1 fw-bold text-primary">DiscordLookup</h1>
                <p class="lead fw-bold text-white">{{ __('Get more out of Discord with Discord Lookup') }}</p>
            </div>
        </div>
    </section>
    <div id="homelist">
        <a href="{{ route('snowflake') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="far fa-snowflake ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Snowflake Decoder') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Get the creation date of a Snowflake, and detailed information about Discord users and guilds.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('userlookup') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-user ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('User Lookup') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Get detailed information about Discord users with creation date, profile picture, banner and badges.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('guildlookup') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-users ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Guild Lookup') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Get detailed information about Discord Guilds with creation date, Invite/Vanity URL, features and emojis.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
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
                            <i class="fab fa-discord ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Guild List') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Show all the guilds you are on, with counters, permissions, features, experiments and more information about the guilds.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('experiments') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-flask ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Discord Experiments') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('All Discord Client & Guild Experiments with Rollout Status and detailed information about Treatments, Groups and Overrides.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('inviteresolver') }}" class="tools-list-item text-decoration-none">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fas fa-link ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Invite Resolver') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Get detailed information about every invite and vanity url including event information.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
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
                            <i class="fas fa-arrows-alt-h ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Snowflake Distance Calculator') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Calculate the distance between two Discord Snowflakes.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
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
                            <i class="fas fa-server ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('Guild Shard Calculator') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('Calculate the Shard ID of a guild using the Guild ID and the total number of shards.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ env('GITHUB_URL') }}" class="tools-list-item text-decoration-none" target="_blank">
            <div class="card text-white bg-dark border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-1 d-flex align-items-center">
                            <i class="fab fa-github ms-auto me-auto"></i>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <p class="fw-bold my-auto">{{ __('GitHub') }}</p>
                        </div>
                        <div class="col-12 col-md-8 d-flex align-items-center">
                            <p class="my-auto">{{ __('DiscordLookup.com is fully open source on GitHub! Feel free to give us a star.') }}</p>
                        </div>
                        <div class="col-0 col-md-1 d-flex align-items-center">
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
