<?php

namespace App\Models;

class Examination extends Model
{
    protected $fillable = ['title', 'file_path', 'subject_id', 'hit_count', 'last_hitted_at'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentHitted();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('subject');
    }

    public function scopeRecentHitted($query)
    {
        // 当考卷抽中时，我们将编写逻辑来更新考卷模型的 hit_count 属性，
        // 此时会自动触发框架对数据模型 last_hit_at 时间戳的更新
        return $query->orderBy('last_hit_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
}
