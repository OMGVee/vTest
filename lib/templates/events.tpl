{while $event->next()}
 {$event->id} {$event->host->name} {$event->service->name} {$event->data} <br />
{/while}
