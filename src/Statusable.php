<?php

namespace Roshangara\Statusable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Roshangara\Statusable\Models\Status;

trait Statusable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @param $value
     */
    public function setStatusAttribute($value)
    {
        $this->setStatus($value);
    }

    /**
     * @param int $status_id
     * @param string|null $reason
     * @param Model|null $agent
     */
    public function setStatus(int $status_id, string $reason = null, Model $agent = null)
    {
        $this->update(['status_id' => $status_id]);

        $this->statuses()->attach($status_id, [
            'status_id' => $status_id,
            'reason' => $reason,
            'agent_type' => $agent->getMorphClass() ?? null,
            'agent_id' => $agent->id ?? null,
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses()
    {
        return $this->morphToMany(Status::class, 'statusable', 'statusable_status')
            ->select([
                'statuses.id',
                'statuses.title',
                'statuses.description',
                'statuses.color',
                'statusable_status.reason',
                'statusable_status.agent_id',
                'statusable_status.agent_type',
                'statusable_status.created_at',
                'statusable_status.updated_at',
            ]);
    }

    /**
     * @param int|null $status
     * @return Model|mixed|null|object|static
     */
    public function getStatus(int $status = null)
    {
        return $status ? $this->getStatusById($status) : $this->getLatestStatus();
    }

    /**
     * @param int $status
     * @return mixed
     */
    public function getStatusById(int $status)
    {
        return $this->statuses()->status($status)->latest()->first();
    }

    /**
     * @return Model|mixed|null|object|static
     */
    public function getLatestStatus()
    {
        return $this->statuses()->latest()->first();
    }

    /**
     * @param int $status
     * @return bool
     */
    public function hasStatus(int $status): bool
    {
        return (bool)$this->statuses()->status($status)->count();
    }
}
