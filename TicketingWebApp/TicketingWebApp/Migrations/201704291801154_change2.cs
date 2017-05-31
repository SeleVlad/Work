namespace TicketingWebApp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class change2 : DbMigration
    {
        public override void Up()
        {
            AlterColumn("dbo.Shows", "Title", c => c.String());
            AlterColumn("dbo.Shows", "Genre", c => c.String());
        }
        
        public override void Down()
        {
            AlterColumn("dbo.Shows", "Genre", c => c.String(nullable: false));
            AlterColumn("dbo.Shows", "Title", c => c.String(nullable: false));
        }
    }
}
