<?php

use Illuminate\Support\Facades\Schedule;

// Генерация sitemap.xml раз в сутки
Schedule::command('sitemap:generate')->daily();
