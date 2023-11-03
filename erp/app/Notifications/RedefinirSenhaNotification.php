<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class RedefinirSenhaNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;
    public $nome;
    
    public function __construct($token, $email, $nome)
    {
       $this->token = $token;
       $this->email = $email;
       $this->nome = $nome;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url("/password/reset/".$this->token .'?email='.$this->email) ;
        $minutos = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        $saudacao = "Olá, " . $this->nome;
        return  (new MailMessage)
        ->subject(Lang::get('Atualização de Senha'))
        ->greeting($saudacao)
        ->line('Este serve para recuperação de sua senha')
        ->action('Clique aqui para modificar a senha', $url)
        ->line('O link acima expira em: ' .$minutos.' minutos' )
        ->line('Se você não solicitou a mudança de senha, então não precisa fazer nada.')
        ->salutation("Até Breve");
        
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
