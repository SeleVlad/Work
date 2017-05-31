namespace TicketingWebApp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class Ticket : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Shows",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        Title = c.String(),
                        Genre = c.String(),
                        Regie = c.String(),
                        Distribution = c.String(),
                        ReleaseDate = c.DateTime(nullable: false),
                        TicketNumber = c.Int(nullable: false),
                    })
                .PrimaryKey(t => t.ID);
            
            CreateTable(
                "dbo.Tickets",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        ShowID = c.Int(nullable: false),
                        ShowTitle = c.String(),
                        Row = c.Int(nullable: false),
                        Number = c.Int(nullable: false),
                    })
                .PrimaryKey(t => t.ID);
            
        }
        
        public override void Down()
        {
            DropTable("dbo.Tickets");
            DropTable("dbo.Shows");
        }
    }
}
