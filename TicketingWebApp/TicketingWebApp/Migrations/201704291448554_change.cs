namespace TicketingWebApp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class change : DbMigration
    {
        public override void Up()
        {
            AlterColumn("dbo.Shows", "Title", c => c.String(nullable: false));
            AlterColumn("dbo.Shows", "Genre", c => c.String(nullable: false));
            AlterColumn("dbo.Shows", "Regie", c => c.String(nullable: false));
            AlterColumn("dbo.Shows", "Distribution", c => c.String(nullable: false));
            AlterColumn("dbo.Tickets", "ShowTitle", c => c.String(nullable: false));
        }
        
        public override void Down()
        {
            AlterColumn("dbo.Tickets", "ShowTitle", c => c.String());
            AlterColumn("dbo.Shows", "Distribution", c => c.String());
            AlterColumn("dbo.Shows", "Regie", c => c.String());
            AlterColumn("dbo.Shows", "Genre", c => c.String());
            AlterColumn("dbo.Shows", "Title", c => c.String());
        }
    }
}
