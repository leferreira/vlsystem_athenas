<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'limite_usuario','limite_nfe','limite_nfce','limite_pdv', 'destaque', 'acesso_nfe','acesso_nfce','valor_setup' ];
    
   /* public function details()
    {
        return $this->hasMany(DetailPlan::class);
    }
    */
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }
    
    public function modulos()
    {
        return $this->belongsToMany(Modulo::class,"plano_modulos");
    }
    
    
    public function search($filter = null)
    {
        $results = $this->where('name', 'LIKE', "%{$filter}%")
        ->orWhere('description', 'LIKE', "%{$filter}%")
        ->paginate();
        
        return $results;
    }
    
    /**
     * Profiles not linked with this plan
     */
    public function profilesAvailable($filter = null)
    {
        $profiles = Perfil::whereNotIn('profiles.id', function($query) {
            $query->select('plan_profile.profile_id');
            $query->from('plan_profile');
            $query->whereRaw("plan_profile.plan_id={$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if ($filter)
                $queryFilter->where('profiles.name', 'LIKE', "%{$filter}%");
        })
        ->paginate();
        
        return $profiles;
    }
}
