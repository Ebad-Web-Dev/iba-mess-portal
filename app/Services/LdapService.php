<?php
// app/Services/LdapService.php

namespace App\Services;

class LdapService
{
    protected $domain;
    protected $ip;
    protected $conn;

    public function __construct()
    {
        $this->domain = 'iba.edu.pk';
        $this->ip = '172.16.1.13';
    }

    public function authenticate($username, $password)
    {
        // Establish connection
        $this->conn = @ldap_connect("ldap://".$this->ip);
        
        if (!$this->conn) {
            return [
                'success' => false,
                'message' => "Could not connect to LDAP server"
            ];
        }

        // Set LDAP options
        ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->conn, LDAP_OPT_REFERRALS, 0);

        // Attempt to bind
        $bind = @ldap_bind($this->conn, $username.'@'.$this->domain, $password);

        if (!$bind) {
            $ldapError = ldap_error($this->conn);
            return [
                'success' => false,
                'message' => $this->parseLdapError($ldapError)
            ];
        }

        return [
            'success' => true,
            'message' => 'Authentication successful'
        ];
    }

    protected function parseLdapError($error)
    {
        // Map common LDAP errors to user-friendly messages
        $errors = [
            '49' => 'Invalid credentials',
            '52' => 'Account disabled',
            '53' => 'Account expired',
            '532' => 'Password expired',
            '773' => 'User must reset password'
        ];

        return $errors[$error] ?? 'Authentication failed';
    }

    public function __destruct()
    {
        if ($this->conn) {
            ldap_close($this->conn);
        }
    }
}