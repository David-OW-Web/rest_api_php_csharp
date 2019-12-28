using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using REST_API;

namespace ForumApp
{
    public partial class Form1 : Form
    {
        private REST_API.REST_API API = new REST_API.REST_API();
        public Form1()
        {
            InitializeComponent();
            var questions = API.getQuestions().QuestionList;
            foreach(var question in questions)
            {
                questionsListBox.Items.Add(question.title);
            }
        }

        private void tabControl1_SelectedIndexChanged(object sender, EventArgs e)
        {
            if(tabControl1.SelectedTab == tabPage1)
            {
                MessageBox.Show("U are on first tab");
            }
        }

        private void questionsListBox_DoubleClick(object sender, EventArgs e)
        {
            questionListView.Items.Clear();
            answersListView.Items.Clear();
            var questionTitle = Convert.ToString(questionsListBox.SelectedItem);
            var questions = API.getQuestions().QuestionList;
            for(int i = 0; i < questions.Count; i++)
            {
                if(questions[i].title == questionTitle)
                {
                    questionListView.Visible = true;
                    string[] content = { questions[i].content, questions[i].created_at.ToString(), questions[i].category, questions[i].username, questions[i].status };
                    ListViewItem lvi = new ListViewItem(content);
                    questionListView.Items.Add(lvi);
                    var answers = API.getAnswers(questions[i].id).AnswerList;
                    foreach(var c in answers)
                    {
                        answersListView.Visible = true;
                        string[] content2 = { c.content, c.created_at.ToString(), c.username };
                        ListViewItem lvi2 = new ListViewItem(content2);
                        answersListView.Items.Add(lvi2);
                    }
                }
            }
        }
    }
}
