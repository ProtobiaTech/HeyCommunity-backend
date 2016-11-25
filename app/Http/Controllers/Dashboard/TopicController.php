<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use App\TopicNode;

class TopicController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $assign['topics'] = Topic::orderBy('id', 'desc')->paginate();
        return view('dashboard.topic.index', $assign);
    }

    /**
     *
     */
    public function getNodes()
    {

        $assign['rootNodes'] = TopicNode::roots()->get();
        return view('dashboard.topic.nodes', $assign);
    }

    /**
     *
     */
    public function getNodeMoveLeft(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
        ]);

        $Node = TopicNode::findOrFail($request->id);
        $r = $Node->moveLeft();

        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function getNodeMoveRight(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
        ]);

        $Node = TopicNode::findOrFail($request->id);
        $r = $Node->moveRight();

        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function postNodeDestroy(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
        ]);

        $Node = TopicNode::findOrFail($request->id);
        Topic::destroy($Node->topics->lists('id')->toArray());
        $Node->delete();

        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function postNodeAdd(Request $request)
    {
        $this->validate($request, [
            'parent_id'     =>      'required|integer',
            'name'          =>      'required|string',
        ]);

        $ParentNode = TopicNode::find($request->parent_id);
        $TopicNode = TopicNode::create(['name' => $request->name]);

        if ($ParentNode) {
            $TopicNode->makeChildOf($ParentNode);
        } else {
            $TopicNode->makeRoot();
        }

        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function postNodeRename(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
            'name'      =>      'required|string',
        ]);

        TopicNode::findOrFail($request->id)->update(['name' => $request->name]);

        return redirect()->to('dashboard/topic/nodes?edit=true');
    }
}
