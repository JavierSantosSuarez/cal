using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Text;

namespace ASM.Library
{
    public class Mail
    {
        public static void EnviaCorreoNoReply(string a, string asunto, string cuerpo)
        {
            var fromAddress = new MailAddress("noreply@asmred.es", "ASM Transporte Urgente");
            const string fromPassword = "FnVIPGLPKOKIHh";

            var toAddress = new MailAddress(a);

            var smtp = new SmtpClient
            {
                Host = "smtp.gmail.com",
                Port = 587,
                EnableSsl = true,
                DeliveryMethod = SmtpDeliveryMethod.Network,
                UseDefaultCredentials = false,
                Credentials = new NetworkCredential(fromAddress.Address, fromPassword)
            };
            using (var message = new MailMessage(fromAddress, toAddress)
            {
                Subject = asunto,
                Body = cuerpo,
                IsBodyHtml = true
            })
            {
                smtp.Send(message);
            }

        }
    }
}
