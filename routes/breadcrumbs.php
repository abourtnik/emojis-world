<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Event;
use App\Models\Emoji;
use Illuminate\Support\Str;


// EMOJI
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('pages.index'));
});

Breadcrumbs::for('emoji', function (BreadcrumbTrail $trail, Emoji $emoji) {
    $trail->parent('home');
    $trail->push(Str::title($emoji->name), $emoji->route);
});


// EVENT
Breadcrumbs::for('events', function (BreadcrumbTrail $trail) {
    $trail->push('Events', route('pages.events.index'));
});

Breadcrumbs::for('event', function (BreadcrumbTrail $trail, Event $event) {
    $trail->parent('events');
    $trail->push($event->name, $event->route);
});

