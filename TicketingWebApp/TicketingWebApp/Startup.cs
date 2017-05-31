using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(TicketingWebApp.Startup))]
namespace TicketingWebApp
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            ConfigureAuth(app);
        }
    }
}
