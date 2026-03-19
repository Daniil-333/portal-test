<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Video;
use App\Models\Article;

Breadcrumbs::for('home.index', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('home.index'));
});

Breadcrumbs::for('home.video_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home.index');
    $trail->push('Медиа', route('home.video_list'));
});

Breadcrumbs::for('home.video_item', function (BreadcrumbTrail $trail, Video $video) {
    $trail->parent('home.video_list');
    $trail->push($video->title, route('home.video_item', $video));
});

Breadcrumbs::for('profile.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home.index');
    $trail->push('Профиль', route('profile.index'));
});

Breadcrumbs::for('article.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home.index');
    $trail->push('Статьи', route('article.index'));
});

Breadcrumbs::for('article.show', function (BreadcrumbTrail $trail, Article $article) {
    $trail->parent('article.index');
    $trail->push($article->title, route('article.show', $article));
});
