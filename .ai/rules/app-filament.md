---
paths:
  - 'app/Filament/**'
---

# App Filament

## Spatie + Shield roles; panel access = has role
Roles/permissions use spatie/laravel-permission + bezhanSalleh/filament-shield (RoleResource is Shield's built-in). App\Models\User uses HasRoles and implements FilamentUser: canAccessPanel() returns $this->roles()->exists() — so a user needs at least one role to enter /admin. Super-admin role name is 'super_admin'. Assign roles in UserResource with Select::make('roles')->relationship('roles','name')->multiple()->preload().
