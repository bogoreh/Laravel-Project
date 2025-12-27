protected function schedule(Schedule $schedule)
{
    $schedule->command('articles:fetch')->everyThirtyMinutes();
}